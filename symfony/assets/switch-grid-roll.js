// Apparition of each part of home page with the switchers 
const switcherGrid = document.querySelectorAll('.switcher-grid');
const switcherRoll = document.querySelectorAll('.switcher-roll');

const candidatesGridWrapper = document.querySelector('#candidates-grid-wrapper');
const candidatesRollWrapper = document.querySelector('#candidates-roll-wrapper');

function appearance(onClickElement, elementToAppear, elementToDisappear) {
	[...onClickElement].map(element => {
		element.addEventListener('click', () => {
			elementToAppear.classList.add('switcher-appearance');
			elementToDisappear.classList.remove('switcher-appearance');
			[...switcherGrid].map(element => {
				element.classList.toggle('on');
			});
			[...switcherRoll].map(element => {
				element.classList.toggle('on');
			});
		});
	});
}


appearance(switcherGrid, candidatesGridWrapper, candidatesRollWrapper); 
appearance(switcherRoll, candidatesRollWrapper, candidatesGridWrapper); 
