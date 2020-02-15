<?php
require_once __DIR__.'./vendor/autoload.php';

  use Siler\GraphQL;
  use Siler\Http\Request;
  use Siler\Http\Response;

  Response\header('Access-Control-Allow-Origin', '*');
  Response\header('Access-Control-Allow-Headers', 'Content-Type');
  response\header('Access-Control-Allow-Methods', '*');

  $schema = '
    type Query {
     resultPerson : [Person!]!
  }
  
  type Mutation {
     addPerson(input: inputPerson) : Person!
  }
  
  input inputPerson {
    name: String!
    age: Int!
  }
  
  type Person {
    name: String!
    age: Int!
  }
   
  ';

  $resolvers = [
  'Query' => [
    'resultPerson' => function($root, $args, $ctx) {
      return [['name' => 'restu'], ['name' => 'wahyu'], ['name' => 'sapura']];
    }
  ],

  'Mutation' => [
     'addPerson' => function ($root,$args, $ctx) {
         return $args['input'];
     }
  ]
];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $Schema = GraphQL\schema($schema, $resolvers);
  GraphQL\init($Schema, NULL, NULL);
} else {
   echo 'Your Request Method Not Allowed';
}