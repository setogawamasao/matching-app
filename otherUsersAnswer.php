<html>
<head>
	<link rel="stylesheet" href="./css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>せとがわまさおマッチングアプリ</title>
</head>
<body>
	<div class="Question-title">みんなの回答</div>
	<?php 
		for($questionNo=1; $questionNo<=7; $questionNo++) :
			// 初期化
			$data = null;
			$answers = [];
			$answers[] = "";
			$answerNums = [];
			$answerNums[] = 0;
			$q3Flag = null; 
			
			// DB接続情報の宣言
			include "./dbConfig.php";
			//$dsn = 'mysql:host=localhost;dbname=matchingApp;charset=utf8';
			//$user = 'matchingAppUser';
			//$password = 'password';
			
			// DBへ接続
			try {
				$db = new PDO($dsn, $user, $password);
				$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

				// プリペアードステートメントを作成
				$sql = "select %colum% ,count(%colum%) as count from answer group by %colum% having %colum% is not null order by %colum%";
				$sql = str_replace("%colum%","q".$questionNo,$sql);
				$stmt = $db->prepare($sql);

				// クエリの実行
				$stmt->execute();
				
				// クエリの実行結果の取得
				while ($row = $stmt->fetch()){
					array_push($answers,$row["q".$questionNo]);
					array_push($answerNums,$row['count']);
				}
			}
			// エラーが発生した場合
			catch(PDOException $e) {
				die ('エラー:' . $e->getMessage());
			}
			
			// 回答文章の読み込み
			// ファイルを指定
			$xml = "./xml/question.xml";
			
			// xmlを読み込む
			$xmlData = simplexml_load_file($xml);
			
			// 対象の質問番号のデータをセット
			$data = $xmlData->question[(int)$questionNo];
			
			// 選択肢が3つある場合
			$q3Flag = false;
			if(!empty(trim($data->answer3Text)))
			{
				$q3Flag = true;
			}
	?>
	<div class="box">
		<p><font size="5em"><?php echo $questionNo ?>:<?php echo $data->questionText ?></font></p>
		<div class="container">
		  <div>
		    <canvas id="myChart<?php echo $questionNo ?>"></canvas>
		  </div>
		</div>
		<script>
			var ctx = document.getElementById("myChart<?php echo $questionNo ?>").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: ["<?php echo $data->answer1Text ?>(<?php echo $answerNums[1] ?>票)", 
					         "<?php echo $data->answer2Text ?>(<?php echo $answerNums[2] ?>票)" 
					         <?php if($q3Flag){echo ','.'"'.$data->answer3Text.'('.$answerNums[3].'票)"';} ?>],
					datasets: [{
						backgroundColor: ["#e74c3c","#4169e1"<?php if($q3Flag){echo ','.'"#00ff00"';} ?>],
						data: [<?php echo $answerNums[1] ?>, 
						       <?php echo $answerNums[2] ?> 
						       <?php if($q3Flag){echo ','.$answerNums[3];} ?>]
					}]
				},
				options: {
					//凡例設定
					legend: {
						labels: {
							// フォントサイズ
							fontSize: 25
						}
					}
				}
			});
		</script>
	</div>
	<?php endfor; ?>
	<div class="href-comment">
		<a href= "index.php">はじめに戻る</a>
	</div>
</body>
</html>