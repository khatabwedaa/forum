let user = window.App.user;

module.exports = {
    owns (model , prop = 'user_id') {
        return model['user_id'] === user.id;
    },

    isAdmin() {
        return ['janeDoe', 'johnDoe', 'khatabWedaa'].includes(user.name);
    }
};

