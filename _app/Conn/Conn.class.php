<?php

/**
 * Conn.class.php [ CONEXAO ]
 * clASSE CONEXAO SINGLETON
 * Retorna um objeto PDO pelo metodo estatico getConn();
 * @copyright (c) year 2016, Oroaldo Esmerio
 */
class Conn {
    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;
    
    /** @var PDO **/
    public static $Connect = null;  //para verificar se objeto já esta conectado   
 
    /** conecta ao banco de dados com pattern singleton  - REtorna objeto PDO - para conexao com outros banco criar dsn de pdo para o banco (seja firebird, sql, etc)**/
    public static function Conectar(){
        try{
            if (self::$Connect == null):
                $dsn = 'mysql:host='.self::$Host.';dbname='.self::$Dbsa;
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
            
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }
        
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }
    
    public static function getConn() {
        return self::Conectar();   ///retorna um objeto pdo singleton
    }
}
