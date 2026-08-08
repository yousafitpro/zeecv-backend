<style>
/* Page Backgrounds & General Setup */
body {
  background: linear-gradient(
                                                            135deg, 
                                                            #fff1ec 0%, 
                                                            #f3e7e9 25%, 
                                                            #e3eeff 60%, 
                                                            #e0f2fe 100%
                                                            );
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: #333333;
}

/* Header Navbar */
.app-header {
  border-bottom: 1px solid #e2ded6;
}

.btn-save {
  background: var(--primary) !important;
  color: #ffffff;
  font-weight: bold;
  border: none;
  transition: background-color 0.2s ease;
}

.btn-save:hover {
  background-color: #fa5252;
  color: #ffffff;
}

/* Content / Template Pill Switcher */
.toggle-pills {
  background-color: #e8e3d8;
}

.btn-pill {
  border: none;
  background: transparent;
  color: #6c757d;
  font-weight: 600;
  font-size: 14px;
  border-radius: 6px;
  padding: 6px 12px;
}

.btn-pill.active {
  background-color: #ffffff;
  color: #212529;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Floating Label Outlined Input System */
.floating-label-group {
  position: relative;
  background-color: #ffffff;
  border: 1px solid #ced4da;
  border-radius: 6px;
  padding: 6px 12px 2px 12px;
}

.floating-label-group label {
  position: absolute;
  top: -9px;
  left: 10px;
  background: #ffffff;
  padding: 0 4px;
  font-size: 11px;
  color: #6c757d;
  margin-bottom: 0;
}

.floating-label-group .form-control {
  border: none;
  padding: 4px 0;
  height: auto;
  font-size: 13px;
  box-shadow: none;
  background: transparent;
}

.floating-label-group .form-control:focus {
  outline: none;
  box-shadow: none;
}

/* Action Icons & Utilities */
.drag-handle {
  cursor: grab;
}

.action-icon {
  cursor: pointer;
  font-size: 13px;
}

.bg-light-item {
  background-color: #fcfbf9;
}

/* AI Button */
.btn-ai {
  background-color: #d8f5a2;
  color: #2b8a3e;
  font-weight: 700;
  border: none;
  font-size: 13px;
  padding: 8px 16px;
}

.btn-ai:hover {
  background-color: #c0eb75;
  color: #2b8a3e;
}

/* Resume Document Sheet */
.resume-sheet {
  min-height: 900px;
  color: #2b2b2b;
}

.resume-name {
  font-size: 24px;
  color: #111111;
}

.resume-subtitle {
  font-size: 12px;
}

.resume-contact {
  font-size: 11px;
  color: #555555;
  line-height: 1.5;
}

.section-heading {
  font-size: 13px;
  letter-spacing: 0.5px;
  border-bottom-color: #a38c73 !important;
}

/* Timeline Custom Bullet & Vertical Line styling */
.timeline-item::before {
  content: '';
  position: absolute;
  left: 3px;
  top: 6px;
  width: 10px;
  height: 10px;
  border: 2px solid #a38c73;
  border-radius: 50%;
  background-color: #ffffff;
  z-index: 2;
}

.timeline-item::after {
  content: '';
  position: absolute;
  left: 7px;
  top: 16px;
  bottom: 0;
  width: 1px;
  border-left: 1px dotted #a38c73;
}

.timeline-item:last-child::after {
  display: none;
}

/* Skill Badges */
.skill-pill {
  background-color: #b0a18f;
  color: #ffffff;
  font-size: 11px;
  padding: 4px 10px;
  border-radius: 4px;
  display: inline-block;
  margin-right: 4px;
  margin-bottom: 6px;
}
</style>