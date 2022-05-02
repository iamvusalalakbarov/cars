<main class="payment">
        <section>
            <h1>Payment and Customer Details</h1>
            <div class="table">
                <div class="left">
                    <h3>Total for rent</h3>
                    <p>Total rent charge</p>
                    <p>Total taxes</p>
                </div>
                <div class="right">
                    <h3>$200.02</h3>
                    <p>$200</p>
                    <p>$0.02</p>
                </div>
            </div>

            <h2><label><i class="fas fa-user"></i></label>Customer Information</h2>
            <form class="guest-info">
                <input type="text" placeholder="First Name">
                <input type="text" placeholder="Last Name">
                <input type="email" placeholder="Email">
            </form>

            <h2><label><i class="far fa-credit-card"></i></label>Payment</h2>
            <form class="card-info">
                <div>
                    <input type="text" placeholder="Card Holder">
                </div>

                <div>
                    <input type="text" pattern="[0-9]" minlength="16" maxlength="19" placeholder="Card Number">
                </div>

                <div>
                    <select name="months" id="months">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>

                    <select name="years" id="years">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2028">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
            </form>

            <a href="#" class="button">Pay</a>
        </section>

        <aside>
            <div class="photo">
                <img src="images/mater.png" alt="Mater">
            </div>
            <h2>Mater</h2>
            <p class="date">6 April - 8 April</p>
            <a href="index.php">Go Back</a>
        </aside>
    </main>