const categoriesOpener = document.querySelectorAll(
	'.wp-block-auto-table-of-contents__category-name'
);
const questionLinks = document.querySelectorAll(
	'.wp-block-auto-table-of-contents__link'
);
const topPage = parseFloat(
	getComputedStyle(document.documentElement)
		.getPropertyValue('--top-page')
		.trim()
);

categoriesOpener.forEach((categoryOpener) => {
	const category = categoryOpener.parentElement;
	if (
		category.querySelector('.current') ||
		category.classList.contains('current')
	) {
		category.classList.add('open');
	}
	categoryOpener.addEventListener('click', () => {
		category.classList.toggle('open');
	});
});

questionLinks.forEach((questionLink) => {
	questionLink.addEventListener('click', () => {
		const questionNumber = questionLink.getAttribute(
			'data-question-number'
		);
		const questionId = `question-${questionNumber}`;
		const questionElement = document.getElementById(questionId);

		if (questionElement) {
			const scrollTo = questionElement.offsetTop - topPage;
			window.scrollTo({ top: scrollTo, behavior: 'smooth' });
		} else {
			const category = questionLink.closest(
				'.wp-block-auto-table-of-contents__category'
			) as HTMLElement;
			const categoryUrl = category.getAttribute('data-category-url');
			window.location.href = categoryUrl;
		}
	});
});
