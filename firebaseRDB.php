<?php
/*
 * class name: firebaseRDB
 * version: 1.0
 * author: Devisty
 */

class firebaseRDB{
   function __construct($url=null) {
      if(isset($url)){
         $this->url = $url;
      }else{
         throw new Exception("Database URL must be specified");
      }
   }

   public function grab($url, $method, $par=null){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      if(isset($par)){
         curl_setopt($ch, CURLOPT_POSTFIELDS, $par);
      }
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 120);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $html = curl_exec($ch);
      return $html;
      curl_close($ch);
   }


   public function insert($table, $data){
      $path = $this->url."/$table.json";
      $grab = $this->grab($path, "POST", json_encode($data));
      return $grab;
   }

   public function update($table, $uniqueID, $data){
      $path = $this->url."/$table/$uniqueID.json";
      $grab = $this->grab($path, "PATCH", json_encode($data));
      return $grab;
   }

   public function delete($table, $uniqueID){
      $path = $this->url."/$table/$uniqueID.json";
      $grab = $this->grab($path, "DELETE");
      return $grab;
   }

   public function deleteTable($table){
      $path = $this->url."/$table.json";
      $grab = $this->grab($path, "DELETE");
      return $grab;
   }


   public function retrieve($dbPath, $queryKey=null, $queryType=null, $queryVal =null){
      if(isset($queryType) && isset($queryKey) && isset($queryVal)){
         $queryVal = urlencode($queryVal);
         if($queryType == "EQUAL"){
               $pars = "orderBy=\"$queryKey\"&equalTo=\"$queryVal\"";
         }elseif($queryType == "LIKE"){
               $pars = "orderBy=\"$queryKey\"&startAt=\"$queryVal\"";
         }
      }
      $pars = isset($pars) ? "?$pars" : "";
      $path = $this->url."/$dbPath.json$pars";
      $grab = $this->grab($path, "GET");
      return $grab;
   }

   public function insertChat($participant1,$participant2, $message) {
        $tempmessage = [
            "message" => $message,
            "receiverid" => $participant2,
            "senderid" => $participant1,
            "timestamp" => time(),
        ];        
        $chatData = [
            'messages' => [
                  time() => $tempmessage
            ],
            'participants' => [
                  $participant2 => $participant1,
                  $participant1 => $participant2,
            ],
        ];

         $tempparts = [
            $participant2 => $participant1,
            $participant1 => $participant2
         ];
         $tempparts2 = [
            $participant1 => $participant2,
            $participant2 => $participant1
         ];
         $result1 = $this->retrieve("chat");
         $result2 = json_decode($result1, 1);

         foreach ($result2 as $key => $result3) {
            if ($result3['participants'] === $tempparts || $result3['participants'] === $tempparts2) {
                // $key contains the unique identifier of the matched record
                $path = "chat/" . $key . "/messages";
                return $this->insert($path, $tempmessage);
            }
        }
         return $this->insert('chat', $chatData);
    }

    public function updateChatMessage($chatId, $message) {
        $path = "chat/" . $chatId . "/messages";
        return $this->insert($path, $message);
    }

    public function retrieveChatMessages($participant1,$participant2) {
      $tempparts = [
          $participant2 => $participant1,
          $participant1 => $participant2
       ];
       $tempparts2 = [
          $participant1 => $participant2,
          $participant2 => $participant1
       ];
       $result1 = $this->retrieve("chat");
       $result2 = json_decode($result1, 1);

       foreach ($result2 as $key => $result3) {
          if ($result3['participants'] === $tempparts || $result3['participants'] === $tempparts2) {
              // $key contains the unique identifier of the matched record
              $path = "chat/" . $key . "/messages";
              return $this->retrieve($path);
          }
      }
      $tempmessage = [
          "message" => "",
          "receiverid" => $participant2,
          "senderid" => $participant1,
          "timestamp" => time(),
      ];        
      $chatData = [
          'messages' => [
                time() => $tempmessage
          ],
          'participants' => [
                $participant2 => $participant1,
                $participant1 => $participant2,
          ],
      ];
      $this->insert('chat', $chatData);
      return $this->retrieve('chat',['participants'],"EQUAL",$chatData['participants']);
  }
}

