<?php

class Usuario{
 
    // conexão com banco de dados e definição de tabelas
    private $conn;
    private $table_name = "usuarios";
 
    // propriedades do objeto
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $nivel;
    public $data;
 
    // construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    }
    
    // lê usuários
    function verificarUsuario(){
        // query que carrega um usuário apenas
        $query =    "SELECT
                        u.id, u.nome, u.email, u.senha, u.nivel, u.data 
                    FROM
                        " . $this->table_name . " u
                    WHERE
                        u.email=? 
                    LIMIT
                        0,1
                    ";

        // prepara query statement
        $stmt = $this->conn->prepare( $query );

        // atualiza o usuário a ser pesquisado pelo email
        $stmt->bindParam(1, $this->email);

        // executa a query
        $stmt->execute();

        // obtem o registro 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // define os valores dos atributos
        $this->id = $row['id'];
        $this->nome = $row['nome'];
        $this->email = $row['email'];
        $this->senha = $row['senha'];
        $this->nivel = $row['nivel'];
        $this->data = $row['data'];
    }
    
    // cadastrar usuario
    /*
        {
            "nome" : "wagner antonio barth",
            "email" : "wagner@wagner.com.br",
            "senha" : "123456",
            "nivel" : "admin"
        }
     */
    function criarUsuario(){

        // query para inserir o registro
        $query =    "INSERT INTO
                        " . $this->table_name . "
                    SET
                        nome=:nome, 
                        email=:email, 
                        senha=:senha, 
                        nivel=:nivel
                    ";
                    
        // prepara a query
        $stmt = $this->conn->prepare($query);

        // limpa caracteres especiais
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->senha=htmlspecialchars(strip_tags($this->senha));
        $this->nivel=htmlspecialchars(strip_tags($this->nivel));
        

        // atualiza valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":nivel", $this->nivel);
  

        // executa query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}

