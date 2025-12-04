<div class="row g-3">

    {{-- Type --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">Address Type</label>
        <select name="type" class="form-select premium-input">
            <option value="home"  @selected(old('type', $address->type ?? '')=='home')>Home</option>
            <option value="work"  @selected(old('type', $address->type ?? '')=='work')>Work</option>
            <option value="other" @selected(old('type', $address->type ?? '')=='other')>Other</option>
        </select>
    </div>

    {{-- Phone --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">Phone</label>
        <input type="text" name="contact_phone"
               class="form-control premium-input"
               value="{{ old('contact_phone', $address->contact_phone ?? '') }}">
    </input>
    </div>

    {{-- Zip --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">Zip Code</label>
        <input type="text" name="zip_code"
               class="form-control premium-input"
               value="{{ old('zip_code', $address->zip_code ?? '') }}">
    </div>

    {{-- Address --}}
    <div class="col-12">
        <label class="form-label fw-bold">Street Address</label>
        <textarea name="address_line" rows="2" class="form-control premium-input">{{ old('address_line', $address->address_line ?? '') }}</textarea>
    </div>

    {{-- City --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">City</label>
        <input type="text" name="city"
               class="form-control premium-input"
               value="{{ old('city', $address->city ?? '') }}">
    </div>

    {{-- State --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">State</label>
        <input type="text" name="state"
               class="form-control premium-input"
               value="{{ old('state', $address->state ?? '') }}">
    </div>

    {{-- Country --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">Country</label>
        <input type="text" name="country"
               class="form-control premium-input"
               value="{{ old('country', $address->country ?? '') }}">
    </div>

</div>
