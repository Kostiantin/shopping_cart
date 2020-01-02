<form class="form-horizontal makeOrderForm" method="POST" action="/?c=order&a=makeOrder">
    <h3>Quick Order</h3>
    <p>
        Please fill out the form and submit it.
        Our customer service will call you within 1 hour.
    </p>
    <div class="form-group">
        <div class="col-sm-12">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" title="First Name">
            <div class="error error-delivery f-hidden">This field is required</div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" title="Last Name">
            <div class="error error-delivery f-hidden">This field is required</div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" title="Email">
            <div class="error error-delivery f-hidden">This field is required</div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" title="Phone">
            <div class="error error-delivery f-hidden">This field is required</div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <label for="delivery">Delivery</label>
            <select class="form-control" required id="delivery" name="delivery">
                <option data-cost="0" value="0">Select</option>
                <option data-cost="0" value="1">Pick Up, costs $0</option>
                <option data-cost="5" value="2">UPS, costs $5</option>
            </select>
            <div class="error error-delivery f-hidden">Delivery is required</div>
        </div>
    </div>
    <div class="error-cart-amount-exceeds-deposit">Not enough money on deposit</div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>