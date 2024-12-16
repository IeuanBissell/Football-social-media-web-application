document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM is fully loaded. Attaching listeners...");

    // Select all buttons with the correct class
    const buttons = document.querySelectorAll('.show-comments-btn');
    console.log("Buttons found:", buttons);

    buttons.forEach(button => {
        console.log("Attaching listener to button:", button);

        button.addEventListener('click', () => {
            const postId = button.getAttribute('data-post-id');
            console.log("Button clicked. Post ID:", postId);

            // Call a function to fetch and display comments
            fetchComments(postId);
        });
    });
});

// Fetch comments for the post using AJAX
function fetchComments(postId) {
    console.log("Fetching comments for Post ID:", postId);

    // Example fetch request
    fetch(`/posts/${postId}/comments`)
        .then(response => response.json())
        .then(data => {
            console.log("Comments data:", data);

            // Update your comments section here
        })
        .catch(error => {
            console.error("Error fetching comments:", error);
        });
}
