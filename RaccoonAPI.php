
<?php

abstract class EventTypes
{
  const View = 'view';
  const AddToCart = 'atc';
}

class RacconRecommendations
{

  function GetCategories():object
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PullURL"] . $config["APIKey"] . '/categories';
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
    return $decoded;
  }

  function GetItems(int $CategoryId, int $PageNumber, int $PageSize):object
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PullURL"] . $config["APIKey"] . '/items/' . $CategoryId . '/' . $PageNumber . '/' . $PageSize;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
    return $decoded;
  }

  function GetRecommended(string $UserId,int $NumberOfRecommendedItems):object
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PullURL"] . $config["APIKey"] . '/items/recommended/'.$UserId. '/' . $NumberOfRecommendedItems;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
    return $decoded;
  }

  function GetPopular(int $NumberOfRecommendedItems):object
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PullURL"] . $config["APIKey"] . '/items/popular/'. $NumberOfRecommendedItems;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
    return $decoded;
  }


  function IngestSession(string $UserId)
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PushURL"] . '/recommend/ingest_session';
    $curl = curl_init($service_url);
    $now = new DateTime();
    $curl_post_data = [
      'epochSeconds' => $now->getTimestamp(),
      'clientApiKey' => $config["APIKey"],
      'sessionId' => $UserId
      ];

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));


    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    echo $curl_response;
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }

 
    return $decoded;
  }

  function AddToCart(string $UserId, int $Qty, int $ItemId, string $ItemName, float $ItemPrice):object
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PushURL"] . '/ingest/event';
    $curl = curl_init($service_url);
    $now = new DateTime();
    $curl_post_data = [
      'action' => EventTypes::AddToCart,
      'amount' => $Qty,
      'category' => 'item',
      'epochSeconds' => $now->getTimestamp(),
      'clientApiKey' => $config["APIKey"],
      'interactive' => true,
      'label' => $ItemId,
      'sessionId' => $UserId,
      'eventData' =>  [
          'iname' => $ItemName,
          'iprice' => $ItemPrice,
          'istatus' => 1 ]
      ];

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));


    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    echo $curl_response;
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
     $this->IngestSession($UserId);
    return $decoded;
  }


  function ViewItem(string $UserId, int $Qty, int $ItemId, string $ItemName, float $ItemPrice):object
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PushURL"] . '/ingest/event';
    $curl = curl_init($service_url);
    $now = new DateTime();
    $curl_post_data = [
      'action' => EventTypes::View,
      'amount' => $Qty,
      'category' => 'item',
      'epochSeconds' => $now->getTimestamp(),
      'clientApiKey' => $config["APIKey"],
      'interactive' => true,
      'label' => $ItemId,
      'sessionId' => $UserId,
      'eventData' =>  [
          'iname' => $ItemName,
          'iprice' => $ItemPrice,
          'istatus' => 2 ]
      ];

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));


    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    echo $curl_response;
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }

 
    return $decoded;
  }


  function SendIngestEvent(string $UserId)
  {
    $config = parse_ini_file('config.ini');
    $service_url = $config["PushURL"] . '/recommend/ingest_session';
    $curl = curl_init($service_url);
    $now = new DateTime();
    $curl_post_data = [

      'epochSeconds' => $now->getTimestamp(),
      'clientApiKey' => $config["APIKey"],
      'sessionId' => $UserId
    ];
  

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    echo $curl_response;
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
    }
    return $decoded;
  }
}
