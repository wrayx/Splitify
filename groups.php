<?php
include "header.php";
$groups = $db->getGroups($userid);
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
    ?>
    <div class="container">
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <h3>Create a Group</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <form action="includes/groups.inc.php" method="POST" id="group-form">
                        <div class="group">
                            <input type="text" name="name" id="group-name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Name</label>
                        </div>
                        <div class="group">
                            <input type="text" name="member-email[]" class="member-email" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Member's username or email</label>
                        </div>
                        <div class="group">
                            <span id="add-member-input"><i class="fas fa-user-plus"></i></span>
                        </div>
                        <div class="group">
                            <button class="button" name="submit" type="submit">
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php foreach ($groups as $group): ?>
            <div class="card">
                <div class="face face1 blue">
                    <div class="content">
                        <h3><?php
                            $groupName = $db->getGroupName($group);
                            echo $groupName; ?></h3>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <div class="tbl-header">
                            <table>
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tbl-content">
                            <table>
                                <tbody>
                                <?php
                                $members = $db->getGroupMembers($group);
                                $i = 0;
                                foreach ($members as $member):
                                    $i++;
                                    $username = $db->getUsername($member);
                                    $email = $db->getUserEmail($member);
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $email; ?>
                                            <button class="button-sm del del-right del-btn"
                                                    id="<?php echo modalId("delete", "trigger", $member) ?>"><i
                                                        class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <button class="button-sm del del-right del-group-btn"
                                id="<?php echo modalId("deletegroup", "trigger", $group) ?>">Delete Group
                        </button>
                    </div>
                </div>
            </div>
            <?php
            $members = $db->getGroupMembers($group);
            $i = 0;
            foreach ($members as $member):
                $i++;
                $username = $db->getUsername($member);
                $email = $db->getUserEmail($member);
                ?>
                <!-- The Member Deletion Modal -->
                <div class="delete-modal" id="<?php echo modalId("delete", "", $member) ?>">
                    <!-- Modal content -->
                    <div class="modal-content">
                                            <span class="close"
                                                  id="<?php echo modalId("delete", "close", $member) ?>"><i
                                                        class="fas fa-times"></i></span>
                        <div class="modal-header">
                            Confirm to Remove This Member ?
                        </div>
                        <p><b>Group Name:</b> <?php echo $groupName; ?></p><br>
                        <p><b>Username:</b> <?php echo $username; ?></p><br>
                        <button class="action red action-rm-member"
                                id="<?php echo modalId("delete", "proceed", $member) ?>">Delete
                        </button>
                        <button class="action blue cancel-btn"
                                id="<?php echo modalId("delete", "cancel", $member) ?>">Cancel
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- The Group Deletion Modal -->
            <div class="group-delete-modal" id="<?php echo modalId("deletegroup", "", $group) ?>">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" id="<?php echo modalId("deletegroup", "close", $group) ?>"><i
                                class="fas fa-times"></i></span>
                    <div class="modal-header">
                        Confirm to Delete this Group ?
                    </div>
                    <p><b>Group Name:</b> <?php echo $groupName; ?></p><br>
                    <button class="action red action-del-group"
                            id="<?php echo modalId("deletegroup", "proceed", $group) ?>">Delete
                    </button>
                    <button class="action blue cancel-btn" id="<?php echo modalId("deletegroup", "cancel", $group) ?>">
                        Cancel
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="js/groups.js" type="module"></script>
    <?php
} else {
    header('Location: signin.php');
}
include "footer.php"
?>