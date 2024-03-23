/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./src/questions/table-of-contents/view.ts ***!
  \*************************************************/
var categoriesOpener = document.querySelectorAll('.wp-block-auto-table-of-contents__category-name');
var questionLinks = document.querySelectorAll('.wp-block-auto-table-of-contents__link');
var topPage = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--top-page').trim());
categoriesOpener.forEach(function (categoryOpener) {
  var category = categoryOpener.parentElement;
  if (category.querySelector('.current') || category.classList.contains('current')) {
    category.classList.add('open');
  }
  categoryOpener.addEventListener('click', function () {
    category.classList.toggle('open');
  });
});
questionLinks.forEach(function (questionLink) {
  questionLink.addEventListener('click', function () {
    var questionNumber = questionLink.getAttribute('data-question-number');
    var questionId = "question-".concat(questionNumber);
    var questionElement = document.getElementById(questionId);
    if (questionElement) {
      var scrollTo = questionElement.offsetTop - topPage;
      window.scrollTo({
        top: scrollTo,
        behavior: 'smooth'
      });
    } else {
      var category = questionLink.closest('.wp-block-auto-table-of-contents__category');
      var categoryUrl = category.getAttribute('data-category-url');
      window.location.href = categoryUrl;
    }
  });
});
/******/ })()
;
//# sourceMappingURL=view.js.map