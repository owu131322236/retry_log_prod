window.goToDetail = function(e) {
    const target = e.currentTarget;
    const targrtType = target.dataset.targetType;
    const targetId = target.dataset.targetId;
    if (!targetId) return;
    if (targrtType.includes('Post')) {
        window.location.href = `/${targetId}/post-show`;
    } else if (targrtType.includes('Comment')) {
        window.location.href = `/${targetId}/comment-show`;
    }
};

window.goToProfile = function(e) {
    e.stopPropagation();
    const userId = e.currentTarget.dataset.userId;
    if (!userId) return;
    window.location.href = `/${userId}/mypage`;
};