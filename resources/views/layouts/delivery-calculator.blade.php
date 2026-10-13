<div class="delivery-calculator">
    <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-truck text-primary fs-5"></i>
        <span class="fw-semibold">Check Delivery</span>
    </div>
    <div class="input-group">
        <input type="text" class="form-control" id="deliveryPincode" placeholder="Enter PIN code" maxlength="6">
        <button class="btn btn-primary" type="button" onclick="checkDelivery()">Check</button>
    </div>
    <div class="delivery-result" id="deliveryResult" style="display: none;">
        <i class="bi bi-check-circle-fill"></i>
        <div>
            <div class="delivery-date" id="deliveryDate">Delivery by <strong>Tomorrow</strong></div>
            <small class="text-muted">Standard delivery available</small>
        </div>
        <span class="delivery-cost" id="deliveryCost">FREE</span>
    </div>
</div>

@push('scripts')
<script>
    function checkDelivery() {
        const pincode = document.getElementById('deliveryPincode').value.trim();
        const result = document.getElementById('deliveryResult');
        
        if (pincode.length < 5) {
            alert('Please enter a valid PIN code');
            return;
        }
        
        // Simulate delivery check (in production, this would be an API call)
        const today = new Date();
        const deliveryDate = new Date(today);
        deliveryDate.setDate(today.getDate() + Math.floor(Math.random() * 3) + 1);
        
        const options = { weekday: 'long', month: 'short', day: 'numeric' };
        const formattedDate = deliveryDate.toLocaleDateString('en-US', options);
        
        document.getElementById('deliveryDate').innerHTML = 'Delivery by <strong>' + formattedDate + '</strong>';
        document.getElementById('deliveryCost').textContent = pincode.startsWith('1') ? 'FREE' : '$5.99';
        result.style.display = 'flex';
    }
</script>
@endpush