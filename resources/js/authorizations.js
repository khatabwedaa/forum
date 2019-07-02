let user = window.App.user;

export function updateReply(reply) {
    return reply.user_id === user.id;
}