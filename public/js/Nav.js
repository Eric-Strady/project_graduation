class Nav {
	constructor() {
		this.nav = '.navbar';
		this.fullOpacity = 'fullOpacity';
		this.checkScrolling();
	}

	checkScrolling() {
		let breakPoint = $(this.nav).height() * 2;
		let self = this;

		$(window).scroll(function(){
			if($(window).scrollTop() > breakPoint){
		        $(self.nav).addClass(self.fullOpacity);
		    }else{
		        $(self.nav).removeClass(self.fullOpacity);
		    }
		});
	}
}

$(function() {
	const nav = new Nav();
});