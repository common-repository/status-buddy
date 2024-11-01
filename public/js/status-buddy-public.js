(function($) {
    'use strict';
    $(document).on('heartbeat-tick', function(e, data) {
        // Only proceed if our EDD data is present
        if (!data['offline_user']) return;
        // Log the response for easy proof it works
        console.log(data['offline_user']);
        data['offline_user'].forEach(function(entry) {
            $('#sb_user_' + entry).css('color','red');
        });

        if (!data['away_users']) return;
        // Log the response for easy proof it works
        console.log(data['away_users']);
        data['away_users'].forEach(function(entry) {
            $('#sb_user_' + entry).css('color','orange');

        });

        if (!data['online_users']) return;
        // Log the response for easy proof it works
        console.log(data['online_users']);
        data['online_users'].forEach(function(entry) {
            $('#sb_user_' + entry).css('color','green');

        });

    });
    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
})(jQuery);