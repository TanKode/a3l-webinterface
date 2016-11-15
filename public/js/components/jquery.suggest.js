jQuery('body').on('site.init', function () {
    jQuery('textarea.suggest').suggest('@', {
        data: USERS,
        map: function (user) {
            return {
                value: user.slug,
                text: '<strong>' + user.slug + '</strong> <small>' + user.username + '</small>'
            }
        }
    })
});