<?php
include "header.php";
$groups = $db->getGroups($userid);
?>
<div class="card">
    <div class="face face1">
        <div class="content">
            <div>Create a Group</div>
        </div>
    </div>
    <div class="face face2">
        <div class="content">
            <form action="includes/groups.inc.php" method="POST" id="group-form">
                <div class="group">
                    <input type="text" name="name" id="group-name" aria-label="group name" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Name</label>
                </div>
                <div class="group">
                    <input type="text" name="members[]" class="member" aria-label="member email or username" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Member's username or email</label>
                </div>
                <div class="group">
                    <span id="add-member-input"><i class="fas fa-user-plus"></i></span>
                </div>
                <div class="group">
                    <button class="button" name="submit" aria-label="submit" type="submit">
                        <span class="text">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($groups as $group): ?>
<div class="card" id="group-card-<?php echo $group; ?>">
    <div class="face face1 blue">
        <div class="content">
            <div><?php
                    $groupName = $db->getGroupName($group);
                    echo $groupName; ?></div>
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
                                    id="<?php echo modalId("delete", "trigger", preg_replace('/\s/', '', $groupName . '_' . $member)) ?>">
                                    Remove
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
    $i = 0; ?>
<div>
    <?php
        foreach ($members as $member):
            $i++;
            $username = $db->getUsername($member);
            $email = $db->getUserEmail($member);
            ?>
    <!-- The Member Deletion Modal -->
    <div class="delete-modal"
        id="<?php echo modalId("delete", "", preg_replace('/\s/', '', $groupName . '_' . $member)) ?>">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close"
                id="<?php echo modalId("delete", "close", preg_replace('/\s/', '', $groupName . '_' . $member)) ?>"><i
                    class="fas fa-times"></i></span>
            <div class="modal-header">
                Confirm to Remove This Member ?
            </div>
            <p><b>Group Name:</b> <?php echo $groupName; ?></p><br>
            <p><b>Username:</b> <?php echo $username; ?></p><br>
            <form action="includes/groups.inc.php" method="POST">
                <input type="hidden" name="group-id" value="<?php echo $group; ?>">
                <input type="hidden" name="member-id" value="<?php echo $member; ?>">
                <button type="submit" class="action red action-rm-member"
                    id="<?php echo modalId("delete", "proceed", preg_replace('/\s/', '', $groupName . '_' . $member)) ?>">
                    Delete
                </button>
                <button class="action blue cancel-btn"
                    id="<?php echo modalId("delete", "cancel", preg_replace('/\s/', '', $groupName . '_' . $member)) ?>">
                    Cancel
                </button>
            </form>
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
            <form action="includes/groups.inc.php" method="post">
                <input type="hidden" name="group-id" value="<?php echo $group; ?>">
                <button type="submit" class="action red action-del-group"
                    id="<?php echo modalId("deletegroup", "proceed", $group) ?>">Delete
                </button>
                <button class="action blue cancel-btn" id="<?php echo modalId("deletegroup", "cancel", $group) ?>">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<script src="js/groups.js" type="module"></script>
<?php
include "footer.php"
?>