class Contracts {
	constructor() {
		this.contracts = $('#contracts button');
		this.summaries = $('.contractSummary');
		this.init();
	}

	init() {
		$(this.summaries).hide();
		$(this.summaries[0]).show();
		$(this.contracts[0]).addClass('active');

		let self = this;
		for (let i = 0; i < this.contracts.length; i++) {
			$(this.contracts[i]).click(function(e) {
				if ($(this).hasClass('active')) {
					e.preventDefault();
				} else {
					self.findVisibleSummary();
					self.showSummary([i]);
				}
			});
		}
	}

	findVisibleSummary() {
		for (let i = 0; i < this.contracts.length; i++) {
			let isVisible = $(this.contracts[i]).css('display');
			if(isVisible !== 'none') {
				this.hideSummary([i]);
			}
		}
	}

	showSummary(index) {
		$(this.contracts[index]).addClass('active');
		$('#' + index).fadeIn(1000);
	}

	hideSummary(index) {
		$(this.contracts[index]).removeClass('active');
		$('#' + index).hide();
	}
}

$(function() {
	const contracts = new Contracts();
});