<?php
	// 合計点
	$sumScore = $_GET["sumScore"];
	
	// ファイルを指定
	$xml = "./xml/question.xml";
	
	// xmlを読み込む
	$xmlData = simplexml_load_file($xml);
	
	// 結果コメントの取得
	if($sumScore <= 40){
		$comment = $xmlData->resultText[0];
	}else if(40 < $sumScore && $sumScore <= 70){
		$comment = $xmlData->resultText[1];
	}else if(70 < $sumScore && $sumScore <= 100){
		$comment = $xmlData->resultText[2];
	}
	
	// データベースに書き込み
	session_start();
	
	include "./dbConfig.php";
	//$dsn = 'mysql:host=localhost;dbname=matchingApp;charset=utf8';
	//$user = 'matchingAppUser';
	//$password = 'password';

	try {
		$db = new PDO($dsn, $user, $password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		// プリペアードステートメントを作成
		$stmt = $db->prepare("
			INSERT INTO answer (ip, date, q1, q2, q3, q4, q5, q6, q7) 
			VALUES (:ip, now(), :q1, :q2, :q3, :q4, :q5, :q6, :q7)"
		);
		
		// パラメータを割り当て
		$stmt->bindParam(':ip', $_SERVER["REMOTE_ADDR"] , PDO::PARAM_STR);
		$stmt->bindParam(':q1', $_SESSION['q1'], PDO::PARAM_STR);
		$stmt->bindParam(':q2', $_SESSION['q2'], PDO::PARAM_STR);
		$stmt->bindParam(':q3', $_SESSION['q3'], PDO::PARAM_STR);
		$stmt->bindParam(':q4', $_SESSION['q4'], PDO::PARAM_STR);
		$stmt->bindParam(':q5', $_SESSION['q5'], PDO::PARAM_STR);
		$stmt->bindParam(':q6', $_SESSION['q6'], PDO::PARAM_STR);
		$stmt->bindParam(':q7', $_SESSION['q7'], PDO::PARAM_STR);
		
		// クエリの実行
		$stmt->execute();
	} catch(PDOException $e) {
		die ('エラー:' . $e->getMessage());
	}
?>
<html>
<head>
	<link rel="stylesheet" href="./css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>せとがわまさおマッチングアプリ</title>
</head>
<body>
	<div class="result-title">Result</div>
	<div class="box">
		<p><font size="10em">マッチング度：<?php echo $sumScore ?>%</font></p>
		<div class="container">
		  <div>
		    <canvas id="myChart"></canvas>
		  </div>
		</div>
		<div class="result-comment"><?php echo $comment ?></div>
	</div>
	<div class="href-comment">
		<a href= "otherUsersAnswer.php">みんなの回答を見る</a>
	</div>
	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'doughnut',
			data: {
				labels: ["マッチしてる", "マッチしてない"],
				datasets: [{
					backgroundColor: ["#e74c3c"],
					data: [<?php echo $sumScore ?>, <?php echo 100 - $sumScore ?>]
				}]
			},
			options: {
				legend: {
					display: false
				}
			}
		});
	</script>
	<script type="text/javascript">
	//　イメージポップアップ表示
		function ImageUp() {
			window.open("https://twitter.com/masaosetogawa","window1","width=1000,height=500,resizable=1,scrollbars=1");
		}
</script>
</body>
</html>
