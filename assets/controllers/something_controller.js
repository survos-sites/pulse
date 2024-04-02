import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static outlets = ['alert']
    // ...
    connect() {
        super.connect();
        console.log(this.identifier, this.alertOutlets, this.hasAlertOutlet);
    }

    clicked() {
        this.alertOutlet.alert('hi from ' + this.identifier);
        console.log(this.identifier + ' clicked');
        this.alertOutlets.forEach(alertOutlet => alertOutlet.alert('hola!'));

    }
}
