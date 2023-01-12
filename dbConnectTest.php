<?php
  $dsn = 'mysql:host=localhost;dbname=matchingApp;charset=utf8';
  $user = 'matchingAppUser';
  $password = 'password';
  
  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // プリペアードステートメントを作成
    $stmt = $db->prepare("INSERT INTO ANSWER (ip, date, q1, q2, q3, q4, q5, q6, q7) VALUES ('1.2.3.4', now(), '1', '1', '1', '1', '1', '1', '1');");
    
    // クエリの実行
    $stmt->execute();
    
  } catch(PDOException $e) {
    die ('エラー:' . $e->getMessage());
  }
?>