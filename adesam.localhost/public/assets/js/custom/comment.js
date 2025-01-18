const firstCommentFormDiv = document.getElementById('firstCommentForm');
const commentsDiv = document.getElementById('comments');

var slug = firstCommentFormDiv.dataset.slug;
var firstCommentUuid = firstCommentFormDiv.dataset.uuid;


loadComments(commentsDiv, firstCommentUuid);

createCommentForm(firstCommentFormDiv, slug, firstCommentUuid, false);


function loadComments(parentDiv, uuid) {
    getAjax(baseUrlDataset + 'occasions/' + slug + '?uuid=' + uuid,
        function (output) {
            var comments = JSON.parse(output);
            Object.values(comments).forEach((value) => {
                createComment(parentDiv, value);
            });
        }
    );
}

function createCommentForm(parentDiv, slug, uuid, cancel) {
    var action = '/occasions/' + slug + '/comments';

    var flexDiv = document.createElement("div");
    flexDiv.classList.add('my-4');
    parentDiv.appendChild(flexDiv);

    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", action);
    flexDiv.appendChild(form);

    var nodesDiv = document.createElement("div");
    nodesDiv.classList.add('row', 'row-cols-1');
    form.appendChild(nodesDiv);

    var hiddenDiv = document.createElement("div");
    var hidden = document.createElement("hidden");
    hidden.setAttribute('name', 'parentId');
    hidden.setAttribute('value', uuid);
    hiddenDiv.appendChild(hidden);
    nodesDiv.appendChild(hiddenDiv);

    var textareaDiv = document.createElement("div");
    textareaDiv.classList.add('col', 'mb-2');
    var textarea = document.createElement("textarea");
    textarea.classList.add('form-control');
    textarea.setAttribute('rows', 2);
    textarea.setAttribute('name', 'comments');
    textarea.setAttribute('placeholder', 'Add to discussion');
    textareaDiv.appendChild(textarea);
    nodesDiv.appendChild(textareaDiv);

    var buttonDiv = document.createElement("div");
    buttonDiv.classList.add('col', 'd-flex', 'column-gap-2');
    nodesDiv.appendChild(buttonDiv);
    var submitButton = document.createElement("button");
    submitButton.classList.add('btn', 'primary-btn');
    submitButton.setAttribute('type', 'submit');
    submitButton.setAttribute('name', 'submit');
    submitButton.textContent = 'Post Comment';
    buttonDiv.appendChild(submitButton);
    if (cancel == true) {
        var cancelButton = document.createElement("button");
        cancelButton.classList.add('btn');
        cancelButton.textContent = 'Cancel';
        buttonDiv.appendChild(cancelButton);
        cancelButton.addEventListener("click", (event) => {
            event.stopPropagation();
            event.preventDefault();

            parentDiv.removeChild(flexDiv);
        });
    }


    form.addEventListener('submit', (event) => {
        event.preventDefault();
        // Perform validation and processing here

        const formData = new FormData();
        formData.append('comments', textarea.value);
        formData.append('parentId', uuid);

        postAjax(action, formData,
            function (output) {
                if (cancel == true) {
                    parentDiv.removeChild(flexDiv);
                }

                window.location.reload();
            },
            function (jqXHR, textStatus, errorThrown) {
                errorAlert('An error occur when posting comment');
            }
        );

    });

}

function createComment(parentDiv, dataComment) {
    var flexDiv = document.createElement("div");
    flexDiv.classList.add('d-flex', 'my-2');
    parentDiv.appendChild(flexDiv);

    var flexShrinkDiv = document.createElement("div");
    flexShrinkDiv.classList.add('flex-shrink-0');
    flexDiv.appendChild(flexShrinkDiv);
    var flexShrinkImage = document.createElement("img");
    flexShrinkImage.classList.add('object-fit-cover');
    flexShrinkImage.setAttribute('width', '80px');
    flexShrinkImage.setAttribute('height', '80px');
    flexShrinkImage.setAttribute('src', dataComment.fileSrc ?? '/assets/images/avatar_user.png');
    flexShrinkImage.setAttribute('alt', dataComment.fileName ?? 'Image not set avatar used');
    flexShrinkDiv.appendChild(flexShrinkImage);

    var flexGrowDiv = document.createElement("div");
    flexGrowDiv.classList.add('flex-grow-1', 'ms-3', 'd-flex', 'flex-column');
    flexDiv.appendChild(flexGrowDiv);
    var flexGrowTitleDiv = document.createElement("div");
    flexGrowTitleDiv.classList.add('mb-1', 'd-flex', 'align-items-center');
    flexGrowDiv.appendChild(flexGrowTitleDiv);
    var flexGrowTitleNameSpan = document.createElement("span");
    flexGrowTitleNameSpan.classList.add('fw-semibold');
    flexGrowTitleNameSpan.textContent = dataComment.name;
    flexGrowTitleDiv.appendChild(flexGrowTitleNameSpan);
    var flexGrowTitleDashSpan = document.createElement("span");
    flexGrowTitleDashSpan.textContent = '\u00A0\u00A0-\u00A0\u00A0';
    flexGrowTitleDiv.appendChild(flexGrowTitleDashSpan);
    var flexGrowTitleDtSpan = document.createElement("span");
    flexGrowTitleDtSpan.textContent = dataComment.createdDateTime;
    flexGrowTitleDiv.appendChild(flexGrowTitleDtSpan);
    var flexGrowMessageParagraph = document.createElement("p");
    flexGrowMessageParagraph.textContent = dataComment.comments;
    flexGrowDiv.appendChild(flexGrowMessageParagraph);

    // Div for buttons (Replies and Reply)
    var flexGrowButtonsDiv = document.createElement("div");
    flexGrowButtonsDiv.classList.add('d-flex', 'column-gap-2');
    flexGrowButtonsDiv.setAttribute('data-replies', dataComment.replies);
    flexGrowDiv.appendChild(flexGrowButtonsDiv);

    // Div for all replies comments
    var flexGrowCommentRepliesDiv = document.createElement("div");
    flexGrowDiv.appendChild(flexGrowCommentRepliesDiv);

    // Button for replies
    if (dataComment.replies > 0) {
        var flexGrowButtonsRepliesButton = repliesButton(flexGrowCommentRepliesDiv, dataComment.replies, dataComment.childId);
        flexGrowButtonsDiv.appendChild(flexGrowButtonsRepliesButton);
    }

    // Button for reply
    var flexGrowButtonsReplyButton = document.createElement("button");
    flexGrowButtonsReplyButton.classList.add('btn', 'primary-btn');
    flexGrowButtonsReplyButton.setAttribute('name', 'reply');
    flexGrowButtonsReplyButton.textContent = 'Reply';
    flexGrowButtonsReplyButton.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();

        var parentCommentFormDivs = document.getElementsByName('flex-grow-comment-form');
        for (let i = 0; i < parentCommentFormDivs.length; i++) {
            parentCommentFormDivs[i].innerHTML = '';
        }

        createCommentForm(flexGrowCommentFormDiv, flexGrowButtonsDiv, flexGrowCommentRepliesDiv, slug, dataComment.childId, true);
    });
    flexGrowButtonsDiv.appendChild(flexGrowButtonsReplyButton);

    // Delete button
    if (dataComment.userId === parseInt(userIdDataset)) {
        var flexGrowButtonsDeleteButton = deleteButton(slug, dataComment.childId);
        flexGrowButtonsDiv.appendChild(flexGrowButtonsDeleteButton);
    }


    var flexGrowCommentFormDiv = document.createElement("div");
    flexGrowCommentFormDiv.setAttribute('name', 'flex-grow-comment-form');
    flexGrowDiv.appendChild(flexGrowCommentFormDiv);



}


function repliesButton(flexGrowCommentRepliesDiv, replies, childId) {
    var flexGrowButtonsRepliesButton = document.createElement("button");
    flexGrowButtonsRepliesButton.classList.add('btn', 'primary-btn');
    flexGrowButtonsRepliesButton.setAttribute('name', 'reply');
    flexGrowButtonsRepliesButton.textContent = replies + ' Replies';
    flexGrowButtonsRepliesButton.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();

        if (flexGrowCommentRepliesDiv.innerHTML === '') {
            loadComments(flexGrowCommentRepliesDiv, childId);
        } else flexGrowCommentRepliesDiv.innerHTML = '';

    });

    return flexGrowButtonsRepliesButton;
}

function deleteButton(slug, childId) {
    var flexGrowButtonsRepliesButton = document.createElement("button");
    flexGrowButtonsRepliesButton.classList.add('btn', 'primary-btn');
    flexGrowButtonsRepliesButton.setAttribute('name', 'reply');
    flexGrowButtonsRepliesButton.textContent = 'Delete';
    flexGrowButtonsRepliesButton.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();

        var href = baseUrlDataset + 'occasions/' + slug + '/comments/' + childId + '/remove';

        deleteAjax(href, successAlert('Removed from comment successfully'));

        window.location.reload();

    });

    return flexGrowButtonsRepliesButton;
}



