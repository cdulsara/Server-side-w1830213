<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/voting.css'); ?>">
    <title>Home Page</title>
    <?php $this->load->view('header', ['title' => 'Home Page']); ?>
</head>
<body>
<div class = "mid"><img src="<?php echo base_url('assets/images/logo.jpg');?>" alt="CLONEL Logo" class="logo" /></div>
<hr>
    <div class="pageView">
    <div>
        <select id="sortQuestions" onchange="sortQuestions()">
            <option value="recent" <?php echo ($sort == 'recent') ? 'selected' : ''; ?>>Most Recent</option>
            <option value="most_upvotes" <?php echo ($sort == 'most_upvotes') ? 'selected' : ''; ?>>Most Upvotes</option>
            <option value="most_downvotes" <?php echo ($sort == 'most_downvotes') ? 'selected' : ''; ?>>Most Downvotes</option>
            <option value="most_views" <?php echo ($sort == 'most_views') ? 'selected' : ''; ?>>Most Views</option>
        </select>
    </div>
    <form class="search-form" action="<?php echo base_url('home'); ?>" method="get">
        <input type="text" class="search_query" name="search_query" placeholder="Search questions by title or username" value="<?php echo $this->input->get('search_query'); ?>">
        <button class="searchBut" type="submit">Search</button>
    </form>
    <div class="add-question">
        <?php if ($logged_in): ?>
            <button class="add-question" id="openModal">Ask a Question</button>
            <div id="questionModal" class="modal">
                <div class="modal-content">
                <h2 class="askHed">Ask Your Question</h2>
                    <span class="close">&times;</span>
                    <form id="questionForm">
                    <label class="ask" for="title">Question Title:</label><br>
                        <input class="askHere" type="text" id="title" name="title" required><br>
                        <label class="ask" for="description">Question Description:</label><br>
                        <textarea class="askHere" id="description" name="description" rows="4" required></textarea><br>
                        <button class="askHereBut" type="submit">Submit</button>
                    </form>

                </div>
            </div>
        <?php else: ?>
            <p>Please <a href="<?php echo base_url('login'); ?>">login</a> to post a question.</p>
        <?php endif; ?>
    </div>
    </div>
    <hr>
    
    <div>
    <?php if ($logged_in): ?>
        <?php foreach($questions as $question): ?>
        <div class="question-card">
            <div class="question-card-title"><a href="<?php echo base_url('question/details/' . $question->id); ?>"><?php echo $question->title; ?></a>
            <p><i class="fas fa-user"></i> <?php echo $question->username; ?></p>
            </div>
            <div class="question-card-vote">
                <span class="upvote-group"><a href="#" class="upvote" onclick="upvoteQuestion(<?php echo $question->id; ?>); return false;"><i class="fas fa-thumbs-up"></i></a><span id="upvotes_<?php echo $question->id; ?>"><?php echo $question->upvotes; ?></span></span>
                <span class="downvote-group"><a href="#" class="downvote" onclick="downvoteQuestion(<?php echo $question->id; ?>); return false;"><i class="fas fa-thumbs-down"></i></a><span id="downvotes_<?php echo $question->id; ?>"><?php echo $question->downvotes; ?></span></span>
            </div>
            <div id="comments">
                    <p><i class="far fa-comment"></i> <?php echo isset($question->comment_count) ? $question->comment_count : '0'; ?></p>
                </div>
            <div class="question-card-views">
            <p>Views: <?php echo $question->view_count; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <?php foreach($questions as $question): ?>
        <div class="question-card">
            <div class="question-card-title"><?php echo $question->title; ?></div>
            <div class="question-card-vote">
                <span class="upvote-group"><a href="<?php echo base_url('login'); ?>" class="upvote"><i class="fas fa-thumbs-up"></i></a><span id="upvotes_<?php echo $question->id; ?>"><?php echo $question->upvotes; ?></span></span>
                <span class="downvote-group"><a href="<?php echo base_url('login'); ?>" class="downvote"><i class="fas fa-thumbs-down"></i></a><span id="downvotes_<?php echo $question->id; ?>"><?php echo $question->downvotes; ?></span></span>
            </div>
            <a href="<?php echo base_url('login'); ?>">View Question</a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
            </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function upvoteQuestion(questionId) {
            $.ajax({
                url: '<?php echo base_url('question/upvote/'); ?>' + questionId,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $('#upvotes_' + questionId).text(response.upvotes);
                        $('#downvotes_' + questionId).text(response.downvotes);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + xhr.responseText); 
                }
            });
        }

        $(document).ready(function() {
        $('#questionForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '<?= base_url("api/post_question"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Question added successfully');
                    document.getElementById('questionModal').style.display = 'none';
                    window.location.reload();
                    $('#questionForm')[0].reset(); 
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('Failed to submit question. Please try again.');
            }
        });
    });

    var modal = document.getElementById('questionModal');
    var btn = document.getElementById('openModal');
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    };

    span.onclick = function() {
        modal.style.display = "none";
        $('#questionForm')[0].reset();
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            $('#questionForm')[0].reset();
        }
    };
});

        function postComment(event, formElement) {
            event.preventDefault(); 
            var formData = $(formElement).serialize(); 

            $.ajax({
                url: '<?php echo base_url('question/post_comment'); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var username = "Your Username"; 
                        var newCommentHtml = '<div class="comment"><p><strong>' + username + ':</strong> ' + $(formElement).find('textarea[name="comment"]').val() + '</p></div>';
                        $(formElement).closest('.question-card').find('#comments').append(newCommentHtml);
                        $(formElement).find('textarea[name="comment"]').val(''); 
                        alert('Comment posted!');
                    } else {
                        alert('Error: ' + (response.error || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        function downvoteQuestion(questionId) {
            $.ajax({
                url: '<?php echo base_url('question/downvote/'); ?>' + questionId,
                type: 'POST', 
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $('#upvotes_' + questionId).text(response.upvotes);
                        $('#downvotes_' + questionId).text(response.downvotes);
                        console.log('Downvote successful');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('questionModal');
            var btn = document.getElementById('openModal');
            var span = document.getElementsByClassName("close")[0];
            btn.onclick = function() {
                modal.style.display = "block";
            }
            span.onclick = function() {
                modal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });

        function sortQuestions() {
            var sortValue = document.getElementById('sortQuestions').value;
            window.location.href = '<?php echo base_url('home?sort='); ?>' + sortValue;
        }
    </script>

</body>
</html>
