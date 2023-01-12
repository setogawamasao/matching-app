// Wrap every letter in a span
$(".ml16").each(function () {
  $(this).html(
    $(this)
      .text()
      .replace(/([^\x00-\x80]|\w)/g, "<span class='letter'>$&</span>")
  );
});

anime.timeline({ loop: false }).add({
  targets: ".ml16 .letter",
  translateY: [-100, 0],
  easing: "easeOutExpo",
  duration: 1200,
  delay: function (el, i) {
    return 180 * i;
  },
  complete: function () {
    $("a").fadeTo(1000, 1);
  },
});
