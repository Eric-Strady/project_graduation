class Simulator {
	constructor() {
		this.init();
	}

	init() {
		console.log($('#simulator_contract'));
	}
}

$(function() {
	const simulator = new Simulator();
});