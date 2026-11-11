jQuery(function ($) {
  const feed = $(".photo-feed").first();
  const pagination = $(".navigation.pagination").first();
  let loading = false;
  let failed = false;

  if (!feed.length || !pagination.length) {
    return;
  }

  $(window).on("scroll", function () {
    const next = pagination.find("a.next").attr("href");
    if (!next || loading || failed || pagination[0].contains(document.activeElement)) {
      return;
    }

    if ($(window).scrollTop() + $(window).height() < $(document).height() - 300) {
      return;
    }

    loading = true;
    $.get(next).done(function (html) {
      const response = $("<div>").append($.parseHTML(html));
      const posts = response.find(".photo-feed .photo-item");
      if (!posts.length) {
        failed = true;
        return;
      }

      feed.append(posts);
      const links = response.find(".navigation.pagination .nav-links").first();
      if (links.length && !pagination[0].contains(document.activeElement)) {
        pagination.find(".nav-links").replaceWith(links);
      } else {
        failed = true;
      }
    }).fail(function () {
      failed = true;
    }).always(function () {
      loading = false;
    });
  });
});
