import { startStimulusApp } from '@symfony/stimulus-bundle';
import Timeago from 'stimulus-timeago';
import Carousel from 'stimulus-carousel'

const app = startStimulusApp();
app.debug = true;
// register any custom, 3rd party controllers here
app.register('timeago', Timeago);
app.register('carousel', Carousel)
