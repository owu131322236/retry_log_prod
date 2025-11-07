document.addEventListener("DOMContentLoaded", () => {
    const navOptions = {
        "timeline": document.getElementById("nav-timeline"),
        "challenges": document.getElementById("nav-challenges"),
        "progress": document.getElementById("nav-progress"),
        "mypage": document.getElementById("nav-profile")
    };

    const currentPath = window.location.pathname;

    Object.keys(navOptions).forEach(key => {
        const el = navOptions[key];
        if (!el) return;

        if (currentPath.includes(key)) {
            // Active
            el.classList.add(
                "font-bold",
                "text-blue-600",
                "text-lg",
            );
        } else {
            el.classList.remove(
                "font-bold",
                "text-blue-600",
                "text-lg",
            );
        }
    });

    const isOnlyUserPage = /^\/\d+\/?$/.test(currentPath);
    if (isOnlyUserPage) {
        const timelineEl = navOptions["timeline"];
        timelineEl.classList.add(
            "font-bold",
            "text-blue-600",
            "text-lg",
            "border-b-2",
            "border-blue-600"
        );
    }
});
