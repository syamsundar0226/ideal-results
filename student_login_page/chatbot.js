let close;

function chatInit(selector) {
	document.addEventListener('DOMContentLoaded', () => {
		if (!window.LIVE_CHAT_UI) {
			let chat = document.querySelector(selector);
			let toggles = document.querySelectorAll('.toggle');
			close = chat.querySelector('.close');

			toggles.forEach(toggle => {
				toggle.addEventListener('click', () => {
					chat.classList.toggle('is-active');
				});
			});

			close.addEventListener('click', () => {
				chat.classList.remove('is-active');
			});

			document.onkeydown = function(evt) {
				evt = evt || window.event;
				var isEscape = false;
				if ("key" in evt) {
					isEscape = (evt.key === "Escape" || evt.key === "Esc");
				} else {
					isEscape = (evt.keyCode === 27);
				}
				if (isEscape) {
					chat.classList.remove('is-active');
				}
			};

			window.LIVE_CHAT_UI = true;
		}
	});
}

chatInit('#chat-app');

/**************Close**************/





/Nastavit parenta cez child/

// let a = document.querySelectorAll('.chat-response:not(#promo) .hotels');
// let yourElements = [];
// for (var i = 0; i < a.length; i++) {
//   yourElements.push(a[i].parentNode);
// }

// yourElements.forEach(e => e.style.padding = "5 rem");




const chat = {
	1: {
		text: 'Hello, Welcome to IBot.',
		next: 2
	},
	2: {
		text: 'Under the Estemeed guidance of Mr.M.S.R.S.PRASAD M.Tech.,[Ph.D] Head of Computer Science Department.',      
		next: 3
	},
	3: {
		text: 'Batch 2019-2023 of students 206K5A0502- J.Syam Sundar, 196K1A0521- N.Maneesh Khanna, 196K1A0546- Ch.Chandra Sekhar, 196K1A0538- U.Sai Sri Harshitha',
		next: 4
	},
	4: {
		text: ' Choose you\'r choice',
		options: [{
			text: "Contact Us",
			next: 5
		}, {
			text: "SGPA",
			next: 6
		}, {
			text: "CGPA",
			next: 7
		}, {
			text: "Percentage",
			next: 8
		}]
	},
	5: {
		text: 'This is a result portal for IDEAL Institute Of Technology. Eamcet code: IDEL. Vidyut Nagar Kakinada - 533003. Phone: 0884-2363345,46,48. Email: principal@idealtech.edu.in , secretary@idealtech.edu.in.',
		options: [{
			text: 'SGPA',
			next: 6
		}, {
			text: "CGPA",
			next: 7
		}, {
			text: "Percentage",
			next: 8
		}]
	},

	6: {
		text: 'Consider For R19 and R16 : O-10, S-9, A-8, B-7, C-6, D-5, F-0 and for R20 consider A+-10, A-9, B-8, C-7, D-6, E-5, F-0 . We should multiply the respective subject credits with given grades. Add each grade products. Then the resultant with sum of the credits. Formula for above SGPA calculation (Si)= Σ(Ci X Gi)/ΣCi.',
		options: [{
			text: 'Contact Us',
			next: 5
		}, {
			text: "CGPA",
			next: 7
		}, {
			text: "Percentage",
			next: 8
		}]
	},

	7: {
		text: 'Calculate Sum of Credits points of All Semesters Divide with Sum of Credits of All Semesters ',
		options: [{
			text: 'Contact Us',
			next: 5
		}, {
			text: "SGPA",
			next: 6
		}, {
			text: "Percentage",
			next: 8
		}]
	},

	8: {
		text: '(CGPA - 0.75)*10 = Percentage.',
		options: [{
			text: 'Contact Us',
			next: 5
		}, {
			text: "SGPA",
			next: 6
		}, {
			text: "CGPA",
			next: 7
		}]
	},
};


const bot = function() {

	const container = document.getElementById('hotel-chatbot-container');
	const inner = document.getElementById('hotel-chatbot-inner');
	const chatbot = document.getElementById('hotel-chatbot');
	let restartButton = null;

	const sleep = function(ms) {
		return new Promise(resolve => setTimeout(resolve, ms));
	};

	const scrollContainer = function() {
		inner.scrollTop = inner.scrollHeight;
	};

	const insertNewChatItem = function(elem) {
		//container.insertBefore(elem, chatbot);
		chatbot.appendChild(elem);
		scrollContainer();
		//debugger;
		elem.classList.add('activated');
	};

	const printResponse = async function(step) {
		const response = document.createElement('div');
		response.classList.add('chat-response');
		response.innerHTML = step.text;
		insertNewChatItem(response);

		await sleep(1500);

		//ak existuju options pre dany step > zobraz ich : zobraz dalsi krok
		if (step.options) {
			const choices = document.createElement('div');
			choices.classList.add('choices');
			step.options.forEach(function(option) {
				const button = document.createElement(option.url ? 'a' : 'button');
				button.classList.add('choice');
				button.innerHTML = option.text;
				if (option.url) {
					button.href = option.url;
				} else {
					button.dataset.next = option.next;
				}
				choices.appendChild(button);
			});
			insertNewChatItem(choices);
		} else if (step.next) {
			printResponse(chat[step.next]);
		}
	};

	const printChoice = function(choice) {
		const choiceElem = document.createElement('div');
		choiceElem.classList.add('chat-ask');
		choiceElem.innerHTML = choice.innerHTML;
		insertNewChatItem(choiceElem);
	};

	const disableAllChoices = function() {
		const choices = document.querySelectorAll('.choice');
		choices.forEach(function(choice) {
			choice.disabled = 'disabled';
		});
		return;
	};

	const handleChoice = async function(e) {

		if (!e.target.classList.contains('choice') || 'A' === e.target.tagName) {
			// Target isn't a button, but could be a child of a button.
			var button = e.target.closest('#hotel-chatbot-container .choice');

			if (button !== null) {
				button.click();
			}

			return;
		}

		e.preventDefault();
		const choice = e.target;

		disableAllChoices();

		printChoice(choice);

		if (choice.outerText === 'Nie ďakujem')
			return close.click();
		scrollContainer();

		await sleep(1500);

		if (choice.dataset.next) {
			printResponse(chat[choice.dataset.next]);
		}
		// Need to disable buttons here to prevent multiple choices
	};

	const handleRestart = function() {
		// options[1];
		// printResponse.clear(); 
		// chat.clear();
		startConversation();
	};

	const startConversation = function() {
		// options[1];
		// chatbot.clear();
		printResponse(chat[1]);

	};

	const init = function() {
		/Prihodil som aj sem container = error container is null/
		const container = document.getElementById('hotel-chatbot-container');
		container.addEventListener('click', handleChoice);

		restartButton = document.createElement('button');
		restartButton.innerText = "Reset Chat";
		restartButton.classList.add('restart');
		restartButton.addEventListener('click', handleRestart);

		container.appendChild(restartButton);

		startConversation();
	};

	init();
};

bot();

/TODO/

//Upravit Restart fuknciu ak sa da cele vymazat a init/load

// Ak sa da tak prihodit dynamicky load tych konecnych ponuk hotelov
