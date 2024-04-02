import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['message'];
    static outlets = ['rlist'];
    static values = {
        id: Number
    }
    // ...
    connect() {
        console.log('outlets?');
        super.connect();
    }

    delete(event) {
        // https://github.com/symfony/symfony/issues/50715
        fetch('/api/reactions/' + this.idValue, { method: 'DELETE' })
            .then(() => this.element.innerHTML = 'Delete from db successful')
            .catch(() => this.element.innerHTML = 'Error deleting');

        console.log('delete this ', this.rlistOutlets.length);
        this.rlistOutlets.forEach(
            rlist => rlist.increment(-1));
        // this.rlistOutlet.increment(-1);
        // this.element.remove();

    }
}
