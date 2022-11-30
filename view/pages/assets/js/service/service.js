class service {

    constructor(settings) {
        this.settings = settings;
        this._service = new httpService();
    }

    get service() {
        return this._service;
    }
}