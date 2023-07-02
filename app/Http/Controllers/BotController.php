<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Chatbot_database;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;
use Illuminate\Support\Facades\Validator;
use Exception;

class BotController extends Controller
{
    public function incomingMessage(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'message' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'input error',
                'input' => $validatedData->errors(),
            ]);
        }
        try {
            $kalimat = $validatedData->validated()['message'];
        
            // Preprocessing
            $kalimat = trim($kalimat);
            $kalimat = preg_replace("/\d+/", "", $kalimat);
        
            // Stopword Removal
            $stopWordRemoverFactory = new StopWordRemoverFactory();
            $stopword = $stopWordRemoverFactory->createStopWordRemover();
            $kalimat = $stopword->remove($kalimat);
        
            // Stemming
            $stemmerFactory = new StemmerFactory();
            $stemmer = $stemmerFactory->createStemmer();
            $kalimat = $stemmer->stem($kalimat);
        
            $userInput = explode(" ", $kalimat);
        
            $database = Chatbot_database::all();
        
            if (empty($database)) {
                throw new Exception("I have no data.");
            }
        
            $database_keyword = [];
            foreach ($database as $record) {
                $keywordArray = json_decode(str_replace("'", '"', $record->keyword));
                $database_keyword[] = $keywordArray;
            }
        
            $commonWords = array_map(function ($entry) use ($userInput) {
                return count(array_intersect($entry, $userInput));
            }, $database_keyword);
            if (max($commonWords) === 0) {
                throw new Exception("Aku tidak mengerti");
            }
            $maxCommonIndex = array_search(max($commonWords), $commonWords);
            if ($maxCommonIndex === false) {
                throw new Exception("No matching response found. so weird.");
            }
        
            $data_result = $database[$maxCommonIndex];
        
            $keywordArray = json_decode(str_replace("'", '"', $data_result->keyword));
            $responseArray = json_decode(str_replace("'", '"', $data_result->response));
        
            $formattedResult = [
                'success' => true,
                'keyword' => $keywordArray,
                'expression' => $data_result->expression,
                'response' => $responseArray,
            ];
        
            return response()->json($formattedResult);
        } catch (Exception $e) {
            $errorResponse = [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        
            return response()->json($errorResponse);
        }  
    }
}