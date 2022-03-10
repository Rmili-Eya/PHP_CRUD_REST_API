<?php

//Headers requis 

//header qui permet d'autoriser ou interdir l'accées au API 
header("Access-Control-Allow-Origin: *");
//header qui nous permet de définir le contenu de réponse 
header("Content-Type: application/json; charset=UTF-8");
//Méthode accepter ou utiliser pour la requête en question
header("Access-Control-Allow-Methods: GET");
//Durée de vie de la requête 
header("Access-Control-Max-Age: 3600");
//Qu'elle sont les Headers qu'ont autorise 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//Pour etre sur que notre API est une API REST et qui respecte le standard , 
//on va vérifier si la méthode utiliser de la poste client est la bonne 

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD']=="GET"){
    //On inclut les fichiers de configuration et d'accées au données 
    include_once "../config/Database.php";
    include_once "../models/Produits.php";
    //On instancie la base de donnée
    $database=new Database();
    $db=$database->getConnection();

    //On instancie les produits 

    $produit=new Produits($db);

    //On récupére les données 

    $stmt=$produit->lire();

    //On vérifie si on a au moins un produit 
    if ($stmt->rowCount()>0){

        //On initialise un tableau associatif 
        $tableauProduits=[];
         //un sous ensemble
        $tableauProduits['produits']=[];
        
        //On parcours les produits
        while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $prod=[
                "id"=>$id,
                "nom"=>$nom,
                "description"=>$description,
                "prix"=>$prix,
                "categories_id"=>$categories_id,
                "categories_nom"=>$categories_nom,
                
            ];
//[] c'est equivalent a push 

            $tableauProduits['produits'][]=$prod;
        }
        //code réponse 200 - ok
        http_response_code(200);
        echo json_encode($tableauProduits);

    }


}else{

   // On gère l'erreur
   http_response_code(405);
   echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}