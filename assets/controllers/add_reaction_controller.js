import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['message']
    // ...
    connect() {
        console.log('hello from ' + this.identifier);
        this.messageTarget.innerHTML = this.identifier + ' connected.';
        super.connect();
    }

}
