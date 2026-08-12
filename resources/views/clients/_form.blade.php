<div class="space-y-6">
    <div class="grid gap-6 grid-cols-1">
        <div class="grid gap-6 grid-cols-1">
            <x-input
                name="name"
                label="Client Name"
                value="{{ old('name', $client->name ?? '') }}"
                required
                placeholder="Enter Client Name"
            />
        </div>

        <div class="grid gap-6 grid-cols-1 md:grid-cols-3">
            <x-input
                name="website"
                label="Website"
                value="{{ old('website', $client->website ?? '') }}"
                placeholder="https://example.com"
                icon="globe-alt"
            />

            <x-input
                name="email"
                label="Email"
                value="{{ old('email', $client->email ?? '') }}"
                placeholder="name@example.com"
                icon="envelope"
            />

            <x-input
                name="phone"
                label="Phone"
                value="{{ old('phone', $client->phone ?? '') }}"
                placeholder="(555) 123-4567"
                type="tel"
                icon="phone"
            />
        </div>

        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
            <x-input
                name="address_line_one"
                label="Address Line One"
                value="{{ old('address_line_one', $client->address_line_one ?? '') }}"
                placeholder="123 Main Street"
            />

            <x-input
                name="address_line_two"
                label="Address Line Two"
                value="{{ old('address_line_two', $client->address_line_two ?? '') }}"
                placeholder="Suite 100, Building A (optional)"
            />
        </div>
        
        <div class="grid gap-6 grid-cols-1 md:grid-cols-3">
            <x-input
                name="city"
                label="City"
                value="{{ old('city', $client->city ?? '') }}"
                placeholder="Enter city"
            />

            <x-input
                name="state"
                label="State/Province"
                value="{{ old('state', $client->state ?? '') }}"
                placeholder="Enter state or province"
            />

            <x-input
                name="postal_code"
                label="Postal Code"
                value="{{ old('postal_code', $client->postal_code ?? '') }}"
                placeholder="Enter postal code"
            />
        </div>
        
        <div class="grid gap-6 grid-cols-1">
            <x-input
                name="country"
                label="Country"
                value="{{ old('country', $client->country ?? '') }}"
                placeholder="Enter country"
            />
        </div>

        <div class="grid gap-6 grid-cols-1">
            <x-textarea
                name="notes"
                label="Notes"
                placeholder="Add any notes aboout this client..."
            >{{ old('notes', $client->notes ?? '') }}</x-textarea>
        </div>

        <div class="grid gap-6 grid-cols-1">
            <x-select
                name="is_active"
                label="Status"
            >
                <option
                    value="1"
                    @selected(old('is_active', $client->is_active ?? true) == true)
                >
                    Active
                </option>

                <option
                    value="0"
                    @selected(old('is_active', $client->is_active ?? true) == false)
                >
                    Inactive
                </option>
            </x-select>
        </div>
    </div>
</div>