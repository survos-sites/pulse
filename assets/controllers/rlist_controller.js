import { Controller } from '@hotwired/stimulus';
import { useMeta } from 'stimulus-use'
/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['reactionCount']
    static values = {
        reactionCount: Number,
    }
    static metaNames = ['userId', 'admin', 'email', 'snake_case_name']

    connect() {
        super.connect();
        useMeta(this);
        console.log('hello from ' + this.identifier + ' starting with ' + this.reactionCountValue);
        this.updateCount(this.reactionCountValue);
    }

    updateCount(n) {
        this.reactionCountTarget.innerText = n;
    }
    increment(inc=1) {
        this.reactionCountTarget.innerText = parseInt(this.reactionCountTarget.innerText) + inc;
    }
    // ...
}
