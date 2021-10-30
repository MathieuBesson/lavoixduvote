const wording = ['une question ?', 'une information ?', 'une correction ?'];
const element = document.querySelector('.contact__dynamic-word');
let currentWord = -1;

window.setInterval(function() {
	currentWord++;
	if (currentWord >= wording.length) {
		currentWord = 0;
	}
	element.textContent = wording[currentWord];
	console.log(currentWord);
}, 3000);
