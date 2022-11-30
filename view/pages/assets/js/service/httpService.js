class httpService {

    _handleErrors(res) {

        if(!res.ok) {

            console.error(res.statusText);
            throw new Error(res.statusText);
        }

        return res;
    }

    get(url) {

        return fetch(url)
            .then(res => this._handleErrors(res))
            .then(res => res.json());

    }

    delete(url) {

        return fetch(url, { method: 'delete' }).then(res => this._handleErrors(res));
    }

    post(url, dado) {

        return fetch(url, {
            headers: { 'Content-type' : 'application/json'},
            method: 'post',
            body: JSON.stringify(dado)
        })
            .then(res => this._handleErrors(res));
    }

    put(url, dado) {

        return fetch(url, {
            headers: { 'Content-type' : 'application/json'},
            method: 'put',
            body: JSON.stringify(dado)
        }).then(res => this._handleErrors(res));
    }

    postJQuery(url, dado) {

        if (typeof jQuery === 'undefined') {
            throw new Error('jQuery não foi carregado na página!');
        }

        return new Promise((resolve, reject) => {

            $.ajax({
                url: url,
                type: 'post',
                data: dado,
                success: response => resolve(response),
                error: erro => reject(erro)
            });

        });
    }
}

class XMLHttpRequestService {

    /**
     * @param formData {FormData}
     * @param data {any}
     * @param parentKey {any}
     * @private
     */
    _buildFromData(formData, data, parentKey) {

        if (data && typeof data === 'object'
            && !(data instanceof Date) && !(data instanceof File)) {

            Object.keys(data).forEach(
                key => this._buildFromData(formData, data[key], parentKey ? `${ parentKey }[${ key }]` : key)
            );
        } else {

            const value = data == null ? '' : data;
            formData.append(parentKey, value);
        }
    }

    /**
     * @param data {Object}
     * @return {FormData}
     */
    jsonToFormData(data) {

        const formData = new FormData();
        this._buildFromData(formData, data);

        return formData;
    }
}