import { createPopper } from '@popperjs/core';
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = createPopper;
    require('bootstrap');
} catch (e) { 
    console.error(e);
}
