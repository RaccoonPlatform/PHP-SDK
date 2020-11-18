<?php


 include 'RaccoonAPI.php';
 $raccoon=new RacconRecommendations();

//user's session Ids
 $user1 = "TestUser1";
 $user2 = "TestUser2";
 $user3 = "TestUser3";
 $user4 = "TestUser4";
 $user5 = "TestUser5";


//  $obj =$raccoon->GetCategories();
//  echo var_dump($obj->{'res'});


//=============================GetItems(CategoryId,Pagenumber,PageSize)======================================

//  $obj =$raccoon->GetItems(3,0,10);
//  echo var_dump($obj->{'res'});

//=============================AddToCart(SessionID,qty,Item_Id,ItemName,ItemPrice)======================================


// $obj=$raccoon->AddToCart($user1,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});


// $obj=$raccoon->AddToCart($user5,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});


//==============================ViewItem(SessionID,qty,Item_Id,ItemName,ItemPrice)===================================

// $obj=$raccoon->ViewItem($user1,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->ViewItem($user2,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->ViewItem($user3,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->ViewItem($user4,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->ViewItem($user4,1,2,"Local Lemon",70);
// echo var_dump($obj->{'res'});


//==============================GetRecommended(SessionID,NumberOfRecommendedItems)======================

// $obj=$raccoon->GetRecommended($user1,2);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->GetRecommended($user2,2);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->GetRecommended($user3,2);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->GetRecommended($user4,2);
// echo var_dump($obj->{'res'});

// $obj=$raccoon->GetRecommended($user5,2);
// echo var_dump($obj->{'res'});

//==============================GetPopular(NumberOfRecommendedItems)====================

// $obj=$raccoon->GetPopular(10);
// echo var_dump($obj->{'res'});


 
