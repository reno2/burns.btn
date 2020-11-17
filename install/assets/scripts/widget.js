function Widget(delay, times, btm_text, theme, afterLoad, url, msg_title, msg_body, text_main_btn, container = false){
	var self = this;
	this.afterLoad = afterLoad;
	this.times = times;
	this.delay = delay;
	this.burns_btn_wrap = document.createElement("div");
	this.burns_btn_wrap.setAttribute('class', 'burns-btn__wrap ' + theme);

	this.start_timer = true;
//this.timerId = '';
	// Main masege
	this.burns_msg = document.createElement('div');
	this.burns_msg.setAttribute('class', 'burns-msg__wrap');


	var HtmlStr = 	 '<div class="burns-msg__body msg-b">';
	HtmlStr +=  	'<div class="burns-msg__body msg-b__left">';
	HtmlStr += 	 	'<div class="burns-msg__body msg-b__img"></div>';
	HtmlStr += 	'</div>';

	HtmlStr += 	'<div class="burns-msg__body msg-b__right">';
	HtmlStr += 		'<div class="msg-b__text">';
	HtmlStr += 					'<span class="msg-b__text_one">'+msg_title+'</span>';
	HtmlStr += 					'<span class="msg-b__text_two">'+msg_body+'</span>';
	HtmlStr += 		'</div>';

	HtmlStr += 		'<div class="msg-b__link">';
	HtmlStr += 				'<a href="'+url+'">'+text_main_btn+'</a>';
	HtmlStr += 		'</div>';

	HtmlStr += 	'</div>';

	HtmlStr += '</div>';
	HtmlStr += '<span class="burns-msg__close"></span>';
	
	this.burns_msg.insertAdjacentHTML('afterBegin', HtmlStr);



	// Main btn
	this.burns_btn = 		 document.createElement('div');
	this.burns_btn.setAttribute('class', 'burns-btn');

	burns_btnHTML = 		'<div class="burns-btn__body">';
	burns_btnHTML  += 			btm_text;
	burns_btnHTML  +=     		'<span class="burns-btn__close"></span>';
	burns_btnHTML  += 		'</div>';

	this.burns_btn.insertAdjacentHTML('afterBegin', burns_btnHTML);

	if(container){
		let container2 = document.querySelector(container);
		container2.after(this.burns_btn_wrap);
	}
	else 
		document.body.after(this.burns_btn_wrap);
	
	let wrap = document.querySelector('.burns-btn__wrap');
	let burns_msg2 = document.querySelector('.burns-msg__wrap');
	wrap.appendChild(this.burns_msg);
	wrap.appendChild(this.burns_btn);

	//this.check4(this.burns_msg); // open
	this.step(this.times); // open

	let closeMSG = document.querySelector('.burns-msg__close');
	
	// click on action link
	let actionLink = document.querySelector('.msg-b__link a');
	actionLink.addEventListener('click', function(){
		sessionStorage.setItem('burns-btn__cnt', 3);

	});

	closeMSG.addEventListener('click', this.close.bind(self));

	this.burns_btn.addEventListener('click', this.open.bind(self));

	this.burns_btn.addEventListener('mouseenter', this.mouseOnElement.bind(self));
	this.burns_btn.addEventListener('mouseleave', this.mouseOutElement.bind(self));
}

Widget.prototype.mouseOutElement = function(){

	var bodyMSG = document.querySelector('.burns-btn__body');
	var btn2 = document.querySelector('.burns-btn');
	console.log(btn2);
	if(bodyMSG.classList.contains('hover') && btn2.classList.contains('hover')){
		bodyMSG.classList.remove('hover');
		btn2.classList.remove('hover');
	}
};

Widget.prototype.mouseOnElement = function(){
	let bodyMSG = document.querySelector('.burns-btn__body');
	let btn2 = document.querySelector('.burns-btn');
	console.log(btn2);
	if(!bodyMSG.classList.contains('hover') && !btn2.classList.contains('hover')){
		bodyMSG.classList.add('hover');
		btn2.classList.add('hover');
	}
};

Widget.prototype.open = function(){
	if(!this.burns_msg.classList.contains('open')){
		this.burns_msg.classList.add('open');
		this.start_timer = false;
	}
};



Widget.prototype.step = function(times_cnt){
	self = this;
	let times = Number(sessionStorage.getItem('burns-btn__cnt'));


	if(times < times_cnt ){
		var myTimer=	setInterval(function() {

			if(self.start_timer) {

				self.func(myTimer);
			}
		}, 1000)

	}

};


Widget.prototype.func = function(myTimer){

	let timer = sessionStorage.getItem('burns-btn__timer');
	let times = sessionStorage.getItem('burns-btn__cnt');

	if(timer == null) timer = 0;

	if(times == null && timer == this.afterLoad && !this.burns_btn.classList.contains('open'))
	{
		console.log('первый раз');
		sessionStorage.setItem('burns-btn__timer', 0);
		this.start_timer = false;
		this.open();
	}
	else if(times < this.times && timer == this.delay && !this.burns_btn.classList.contains('open'))
	{
		console.log('второй раз');
		sessionStorage.setItem('burns-btn__timer', 0);
		this.start_timer = false;
		this.open();
	}
	else if(times == this.times)
	{
		clearTimeout(myTimer);
	}
	else{
		timer = Number(timer) + 1;
		sessionStorage.setItem('burns-btn__timer', timer);
	}
};


Widget.prototype.close = function(){
	console.log(this.burns_msg);
	if(this.burns_msg.classList.contains('open')){
		this.burns_msg.classList.remove('open');
		let cookie = sessionStorage.getItem('burns-btn__cnt');
		if(cookie < this.times){
			let self = this;
			cookie++;
			sessionStorage.setItem('burns-btn__cnt', cookie);
			this.start_timer = true;
			//this.delay3(self);
		}
		else if(cookie == null)
		{
			sessionStorage.setItem('burns-btn__cnt', 1);
		}
		else{
			this.start_timer = false;
			//clearInterval(this.timerId) 
			//this.delay3(self);
		}
	}
};

Widget.prototype.delay3 = function(el){
	setTimeout(function(){
		console.log(this);
		el.check4(el.burns_msg);
	}, this.delay)
};

Widget.prototype.level = function(){
	let cook =  sessionStorage.getItem('burns-btn__cnt');
	if(cook == null) return 'f';
	else if(cook < this.times) return 's';
	else return 'm';

};

Widget.prototype.check4 = function(el){
	console.log(this.level() );
	if(this.level() == 'f' && !el.classList.contains('open')){
		setTimeout(function(){
			el.classList.add('open');
		}, this.afterLoad)
	}
	else if(this.level() == 's' && !el.classList.contains('open')){
		setTimeout(function(){
			el.classList.add('open');
		}, this.delay)
	}
};


document.addEventListener("DOMContentLoaded", ready);

function ready() {
	var params = document.querySelector('#burns_btn-params').getAttribute('data-params');
	var settings = JSON.parse(params);
	console.log(settings);
	if(settings.switch_on == 'Y'){
		new Widget(
			settings.timer, 
			settings.times, 
			settings.text_btn, 
			settings.theme, 
			settings.delay, 
			settings.url, 
			settings.msg_title,
			settings.msg_body,
			settings.text_main_btn,
			);
	}
}