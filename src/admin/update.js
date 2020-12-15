/**
 * Handles reloading of page to prohibit resubmission of forms.
 * @author Alvin John Cutay
 */
if (window.history.replaceState) {
    window.history.replaceState( null, null, window.location.href );
}