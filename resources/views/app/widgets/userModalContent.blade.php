<div class="ct-employee-card">
  <div class="ct-employee-avatar">
    <img src="{{$user->avatar()}}" alt="Avatar">
  </div>
  <div class="ct-employee-info">
    <h5 class="ct-employee-name">{{$user->name}}</h5>
    <p class="ct-employee-title">User ID | #{{unique_encrypt($user->id)??''}}</p>

    <div class="ct-employee-badges">
        @if (is_has_role('Merchant'))
        <span class="ct-badge ct-badge-blue">Merchant</span>
        @endif
    @if (is_has_role('Marketer'))
      <span class="ct-badge ct-badge-green">Marketer</span>
      @endif
      <span class="ct-badge ct-badge-gold">Member</span>
    </div>
  </div>
</div>

<style>
.ct-employee-card {
  display: flex;
  background: #fff;
  border-radius: 10px;
  padding: 16px;
  max-width: 500px;
  font-family: "Segoe UI", sans-serif;
}

.ct-employee-avatar img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 16px;
}

.ct-employee-info {
  flex: 1;
}

.ct-employee-name {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 4px;
}

.ct-employee-title {
  color: #6c757d;
  margin-bottom: 10px;
}

.ct-employee-contact {
  list-style: none;
  padding: 0;
  margin: 0 0 12px;
  font-size: 0.95rem;
}

.ct-employee-contact li {
  margin-bottom: 4px;
}

.ct-employee-contact i {
  margin-right: 8px;
  color: #888;
}

.ct-employee-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.ct-badge {
  padding: 4px 10px;
  font-size: 0.75rem;
  border-radius: 12px;
  font-weight: 500;
  display: inline-block;
}

.ct-badge-blue {
  background-color: #007bff;
  color: white;
}

.ct-badge-green {
  background-color: #28a745;
  color: white;
}

.ct-badge-gold {
  background-color: #ffc107;
  color: #212529;
}
</style>
