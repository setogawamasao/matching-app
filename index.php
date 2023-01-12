<html>

<head>
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style type="text/css">
  body {
    /* 画像ファイルの指定 */
    background-image: url(./img/love-heart-hands_4460x4460.jpg);
    /* 画像を常に天地左右の中央に配置 */
    background-position: center center;
    /* 画像をタイル状に繰り返し表示しない */
    background-repeat: no-repeat;
    /* コンテンツの高さが画像の高さより大きい時、動かないように固定 */
    background-attachment: fixed;
    /* 表示するコンテナの大きさに基づいて、背景画像を調整 */
    background-size: cover;
  }

  a {
    display: none;
  }
  </style>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>せとがわまさおマッチングアプリ</title>
</head>

<body>
  <div class="wf-kokoro">
    <font color="white">
      <div class="ml16">せとがわまさお</div>
      <div class="ml16">マッチングアプリ</div>
    </font>
    <a href="javascript:form1.submit()">はじめる</a>
    <form name="form1" action="question.php" method="post">
      <input type="hidden" name="ans" value="9">
      <input type="hidden" name="questionNo" value=1>
      <input type="hidden" name="sumScore" value=0>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
  <script type="text/javascript" src="animation.js"></script>
</body>

</html>