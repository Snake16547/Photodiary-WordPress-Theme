jQuery(function ($) {
  if (!$("body").hasClass("blog") && !$("body").hasClass("archive")) return;

  let page = 2;
  let loading = false;
  let max = photodiary_infinite.max;

  $(window).scroll(function () {
    if (loading) return;
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 300) {
      if (page > max) return;
      loading = true;
      $.get(window.location.href + "page/" + page + "/", function (data) {
        const posts = $(data).find(".photo-feed .photo-item");
        $(".photo-feed").append(posts);
        page++;
        loading = false;
      });
    }
  });
});