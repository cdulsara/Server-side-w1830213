<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/voting.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/profile.css'); ?>">
    <!-- <form id="editProfileForm" action="<?php echo base_url('user/update_profile'); ?>" method="post" style="display:none;"> -->
    <?php $this->load->view('header', ['title' => 'Home Page']); ?>
    
</head>
<body>
    <div class = "mid"><img src="assets/images/logo.jpg" alt="CLONEL" class="logo" /></div>
    <hr>
    <h2 class="askHed">User Profile</h2>
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'ProfileDetails')">Profile Details</button>
        <button class="tablinks" onclick="openTab(event, 'YourQuestions')">Your Questions</button>
    </div>

    <div id="ProfileDetails" class="tabcontent">
        <!-- Display Flash Messages -->
        <?php if ($this->session->flashdata('error')): ?>
            <p class="flash-message" style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <p class="flash-message" style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
        <?php endif; ?>
        <div class="profileDetails" id="viewProfile">
        <h3>Profile Details</h3>
            <table class='tableDe'>
                <tr>
                    <td>Username: </td>
                    <td><?php echo htmlspecialchars($user->username); ?></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><?php echo htmlspecialchars($user->email); ?></td>
                </tr>
                <tr>
                    <td>Joined Date: </td>
                    <td><?php echo htmlspecialchars(date('F j, Y', strtotime($user->joined_date))); ?></td>
                </tr>
                <tr>
                    <td>First Name: </td>
                    <td><?php echo htmlspecialchars($user->first_name); ?></td>
                </tr>
                <tr>
                    <td>Last Name: </td>
                    <td><?php echo htmlspecialchars($user->last_name); ?></td>
                </tr>
                <tr>
                    <td>Mobile Number: </td>
                    <td><?php echo htmlspecialchars($user->mobile); ?></td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td><?php echo htmlspecialchars($user->address); ?></td>
                </tr>
            </table>
            <button class='edit' onclick="toggleEditForm()">Edit</button>
        </div>
        <div class="dataEdit">
        <form id="editProfileForm" action="<?php echo base_url('user/update_profile'); ?>" method="post" style="display:none;">
        <!-- Adding fields for username and email in the edit form -->
        <table class="tableEdit">
            <tr>
                <td>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->username); ?>" required>
                </td>
                <td>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
                </td>
                <td>
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user->first_name); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user->last_name); ?>">
                </td>
                <td>
                    <label for="mobile">Mobile Number:</label>
                    <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user->mobile); ?>">
                </td>
                <td>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user->address); ?>">
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><button type="button" onclick="toggleEditForm()">Cancel</button>  <button type="submit">Save Changes</button></td>
            </tr>
        </table> 
        </form>
        </div>
    </div>

    <div id="YourQuestions" class="tabcontent">
        <h3 class='myQu'>Your Questions</h3>
        <?php if (!empty($questions)): ?>
            <ul>
                <?php foreach ($questions as $question): ?>
                    <p class='qu'><a href="<?php echo base_url('question/details/' . $question->id); ?>"><?php echo htmlspecialchars($question->title); ?></a></p>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No questions posted yet.</p>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(clearMessages, 10000); // Clear messages after 10 seconds
        });

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";

            // Clear messages when tab is switched
            // clearMessages();
        }

        function clearMessages() {
            const messages = document.querySelectorAll('.flash-message');
            messages.forEach(msg => {
                msg.style.display = 'none';
            });
        }

        // Set the default tab
        document.getElementsByClassName('tablinks')[0].click();

        function toggleEditForm() {
            var form = document.getElementById('editProfileForm');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

    </script>
</body>
</html>
