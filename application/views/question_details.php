<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/voting.css'); ?>">
    <?php $this->load->view('header', ['title' => 'Home Page']); ?>
    <title>Question Details</title>
</head>
<body>
    <!-- <h1>Question Details</h1> -->
    <div class='qDetails'>
    <h2><?php echo $question->title; ?></h2>
    <p><i class="fas fa-at"></i><?php echo $question->username; ?></p>
    <p><i class="fas fa-calendar"></i> <?php echo date('F j, Y', strtotime($question->created_at)); ?></p>
    <p><i class="far fa-eye"></i> <?php echo $question->view_count; ?></p>
    <p><?php echo $question->description; ?></p>
    <!-- <h3>Comments: <p><i class="far fa-comment"></i> <?php echo $question->comment_count; ?></p></h3> -->
    <h3>Comments: <span id="comment_count"><?= $comment_count; ?></span></h3>
    <span class="upvote-group <?= $question->user_vote == 'up' ? 'active' : '' ?>" id="upvote_group_<?= $question->id; ?>">
        <a href="#" class="upvote" onclick="upvoteQuestion(<?= $question->id; ?>); return false;">
            <i class="fas fa-thumbs-up"></i>
        </a>
        <span id="upvotes_<?= $question->id; ?>"><?= $question->upvotes; ?></span>
    </span>
    <span class="downvote-group <?= $question->user_vote == 'down' ? 'active' : '' ?>" id="downvote_group_<?= $question->id; ?>">
        <a href="#" class="downvote" onclick="downvoteQuestion(<?= $question->id; ?>); return false;">
            <i class="fas fa-thumbs-down"></i>
        </a>
        <span id="downvotes_<?= $question->id; ?>"><?= $question->downvotes; ?></span>
    </span>
    </div>
    <div class='commentForm'>
        <table>
        <form id="commentForm">
            <tr>
                <td class='td1'><input type="hidden" id="question_id" name="question_id" value="<?php echo $question->id; ?>">
            <textarea id="comment" name="comment" required></textarea><td>
                <td class='td2'><button type="button" onclick="postComment()">Post Comment</button><td>
            </tr>
        </form>
        </table>
    </div>    
    
<div class="question-card-vote">
    
</div>

    <div id="comments">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <!-- <div class="comment">
                    <p><span style="font-weight: 700;"><?php echo $comment->username; ?> : </span><span><?php echo htmlspecialchars($comment->comment); ?></span></p>
                    <?php if ($comment->user_id == $this->session->userdata('user_id')): ?>
                        <button onclick="deleteComment(<?= $comment->id; ?>)">Delete</button>
                    <?php endif; ?>
                </div> -->
                <div class='comments' id="comment_<?= $comment->id ?>" class="comment">
                <p><span style="font-weight: 700;"><?php echo $comment->username; ?> : </span><span><?php echo htmlspecialchars($comment->comment); ?></span><span class='deleteCom'><?php if ($comment->user_id == $this->session->userdata('user_id')): ?>
                        <i class="fas fa-trash" onclick="deleteComment(<?= $comment->id; ?>)">Delete</i>
                    <?php endif; ?></span></p>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </div>

<!-- Add comment form -->

     
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>


function handleVote(response, questionId) {
    $('#upvotes_' + questionId).text(response.upvotes);
    $('#downvotes_' + questionId).text(response.downvotes);
    if(response.currentVote === 'up') {
        $('#upvote_group_' + questionId).addClass('active');
        $('#downvote_group_' + questionId).removeClass('active');
    } else if(response.currentVote === 'down') {
        $('#downvote_group_' + questionId).addClass('active');
        $('#upvote_group_' + questionId).removeClass('active');
    } else {
        $('#upvote_group_' + questionId).removeClass('active');
        $('#downvote_group_' + questionId).removeClass('active');
    }
}

function upvoteQuestion(questionId) {
    $.ajax({
        url: '<?= base_url("question/upvote/"); ?>' + questionId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            handleVote(response, questionId);
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
}

function downvoteQuestion(questionId) {
    $.ajax({
        url: '<?= base_url("question/downvote/"); ?>' + questionId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            handleVote(response, questionId);
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
}
    function postComment() {
        var questionId = $('#question_id').val();
        var comment = $('#comment').val();
        
        $.ajax({
            url: '<?php echo base_url('question/post_comment'); ?>',
            type: 'POST',
            data: { question_id: questionId, comment: comment },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Reload the page or update comments dynamically
                    location.reload();
                } else {
                    alert('Error: ' + (response.error || 'Unknown error'));
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    }


function deleteComment(commentId) {
        if (!confirm('Are you sure you want to delete this comment?')) {
        return; // Stop if the user cancels the deletion.
    }
    $.ajax({
        url: '<?= base_url("question/delete_comment/"); ?>' + commentId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Remove the comment from the DOM
                $('#comment_' + commentId).remove();
                // Update the comment count display for the associated question
                $('#comment_count').text(response.new_comment_count);  // Correctly target the element with ID 'comment_count'
            } else {
                alert('Failed to delete comment: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
}




</script>
</body>
</html>
