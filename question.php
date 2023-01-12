<?php
	// ファイルを指定
	$xml = "./xml/question.xml";
	
	// xmlを読み込む
	$xmlData = simplexml_load_file($xml);
	
	// Quesiton番号
	$questionNo = $_POST['questionNo'];
	
	// 回答
	$ans = $_POST['ans'];
	
	// 合計点
	$sumScore = $_POST['sumScore'];
	
	// 前の質問番号のデータをセット
	if ($questionNo != 1){
		$prevData = $xmlData->question[$questionNo-1];
		
		// 判定
		if ($ans == "1"){
			$sumScore = $sumScore + $prevData->answer1Point;
		} else if ($ans == "2"){
			$sumScore = $sumScore + $prevData->answer2Point;
		} else if ($ans == "3"){
			$sumScore = $sumScore + $prevData->answer3Point;
		}
		
		// 回答をセッションに設定
		session_start();
		
		$prevQuestionNo = $questionNo-1;

		$_SESSION["q" . (string)$prevQuestionNo] = $ans; 
	}
	
	// 対象の質問番号のデータをセット
	$data = $xmlData->question[(int)$questionNo];
	
	// 次のQuesiton番号
	$nextQuestionNo = $questionNo + 1;
	
	// 質問がすべて完了したら、結果画面へ遷移
	if($data->questionText == "LAST"){
		header("Location: result.php?sumScore=".$sumScore);
	}else{
	// 質問フォームを表示
?>
<html>
	<head>
		<script>
			function goSubmit(val){
				document.form1.ans.value = val;
				document.form1.submit();
			}
		</script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="./css/style.css">
		<title>せとがわまさおマッチングアプリ</title>
	</head>
	<body>
	    <div class="Question-title">Question<?php echo $questionNo ?></div>
		<div class="box">
			<p><?php echo $data->questionText ?></p>
			<p class="image">
				<img src="./img/<?php echo $data->imageName ?>">
			</p>
			<form name="form1" action="<?php echo $data->nextFormAction ?>" method="post">
				<div onclick="javascript:goSubmit('1')" class="answer"><?php echo $data->answer1Text ?></div>
				<div onclick="javascript:goSubmit('2')" class="answer"><?php echo $data->answer2Text ?></div>
				<?php if(!empty(trim($data->answer3Text))){ 
				echo "<div onclick=\"javascript:goSubmit('3')\" class=\"answer\">".$data->answer3Text."</div>";
				} ?>
				<input type="hidden" name="ans" value="">
				<input type="hidden" name="questionNo" value="<?php echo $nextQuestionNo ?>">
				<input type="hidden" name="sumScore" value= "<?php echo $sumScore ?>" >
			</form>
		</div>
	</body>
</html>
<?php } ?>
