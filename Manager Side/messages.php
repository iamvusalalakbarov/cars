<?php

$messages = $db->query("SELECT * FROM messages")->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="messages">
            <table>
                <thead>
                    <tr>        
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo $message["firstname"]; ?></td>
                            <td><?php echo $message["surname"]; ?></td>
                            <td><?php echo $message["email"]; ?></td>
                            <td><p><?php echo $message["message"]; ?></p></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>