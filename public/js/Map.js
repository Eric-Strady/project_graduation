class Map {
	constructor(container, lat, lng, markerTitle) {
		this.container = container;
		this.lat = lat;
		this.lng = lng;
		this.markerTitle = markerTitle;
		this.map;
		this.generateMap();
	}

	generateMap() {
		this.map = L.map(document.getElementById(this.container)).setView([this.lat, this.lng], 13);
		this.getLayer();
		this.generateMarkers();
		return this.map;
	}

	getLayer() {
		L.tileLayer('//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
		    attribution: 'donn&eacute;es &copy; <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
		    maxZoom: 18,
		}).addTo(this.map);
	}

	generateMarkers() {
		let marker = L.marker([this.lat, this.lng])
			.addTo(this.map)
			.bindPopup(this.markerTitle).openPopup();
	}
}

$(function() {
	const map = new Map('map', latitude, longitude, markerTitle);
});