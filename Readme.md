## GraphQL Example With PHP

![](https://i.imgur.com/lNZUTQS.png)

**Tutorial** sebelumnya saya sudah pernah membahas `GraphQL` mengunakan `Express` dan `Apollo Server`, tapi kali ini saya akan membahas `GraphQL` mengunakan `PHP` dan mengunakan library `Siler GraphQL`, kenapa saya mengunakan `Siler GraphQL ?` karena `Siler GraphQL` konsepya mirip dengan `Apollo Server`, `Graphiql` dan `GraphQL Yoga` pada `NodeJS`, pada umumnya `GraphQL` digunakan untuk melakukan komunikasi pertukaran data antara client dan server seperti `REST API` dan `GraphQL` juga bisa dibilang cara paling modern untuk melakukan komunikasi pertukaran  data sebagai alternative jika anda tidak mau mengunakan `REST API`, untuk info lebih lanjut mengenai `GraphQL` silahkan anda bisa kunjungi situs berikut [graphql.org](https://graphql.org/)

#### Step One

- install `composer` terlebih dahulu bisa download di sini [link](https://getcomposer.org/)
- buat folder di `httdocs` dengan nama contoh `graphql-example` 
- buka terminal ketikan ini `composer init`
- install module `Siler GraphQL` silahkan cek disini [link](https://packagist.org/packages/leocavalcante/siler)
- tambahkan `scripts: { "dev": php -S localhost:3000/graphql index.php }`, pada `composer.json` atau bisa mengunakan web server seperti `Nginx`
- jalankan perintah `composer run dev` melalui terminal

#### Step Two

-  install `GraphQL Playground` atau bisa mengunakan extension Chrome `Altar GraphQL`
- load module `Siler GraphQL` seperti dibawah ini

<pre><code> require_once __DIR__.'./vendor/autoload.php';

  use Siler\GraphQL;
  use Siler\Http\Request;
  use Siler\Http\Response;

  Response\header('Access-Control-Allow-Origin', '*');
  Response\header('Access-Control-Allow-Headers', 'Content-Type');
  response\header('Access-Control-Allow-Methods', '*');

</code></pre>

- buat file untuk `schema graphql` dengan nama contoh `example.graphql` dan load mengunakan `file_get_contents() `

- atau bisa membuat `schema graphql`  juga bisa dengan cara seperti ini

<pre><code> $schema = '
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
  ';</code></pre>
  
  - buat sebuah `resolvers` untuk menampilkan sebuah data dan menambahkan sebuah data
  
  <pre><code> $resolvers = [
  
	  //untuk menampilkan data
	  'Query' => [
		'resultPerson' => function($root, $args, $ctx) {
		  return [['name' => 'restu wahyu saputra'], ['age' => 23]];
		}],
  
	  //untuk menambahkan data
	  'Mutation' => [
		 'addPerson' => function ($root,$args, $ctx) {
			 return $args['input'];
		 }]
	 ];
  </code></pre>
  
  - buat perintah untuk mengeksekusi `Schema dan Resolvers` seperti dibawah ini
  
   <pre><code>
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
	  $Schema = GraphQL\schema($schema, $resolvers);
	  GraphQL\init($Schema, NULL, NULL);
	  
	} else {
	   echo 'Your Request Method Not Allowed';
	}
   </code></pre>
   
   ### StepThree
   
   - buka `GraphQL Playground ` atau `Altar GraphQL`
   - copy URL yang sudah dibuat tadi melalu `composer run dev` ke playground `GraphQL`
   - tuliskan `Query` untuk menampilkan sebuah nilai pada `GraphQL` seperti dibawah ini
   
   <pre><code>query tampilkanData {
		 resultPerson {
		    name
			age
		 }
		}
   </code></pre>

-  tuliskan `Mutation` untuk menambahkan sebuah nilai pada `GraphQL` seperti dibawah ini

<pre><code>mutation tambahData {
      addPerson(input: {
           name: "Rima Triana",
           age: 21
      }), {
       name
       age
    }
  }
</code></pre>
- selamat anda telah berhasi membuat simple `REST API` mengunakan `GraphQL` 