// Test form submission simulation
console.log("Testing form submission...");

// Simulate form data
const formData = new FormData();
formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
formData.append('prompt', 'I need a birthday gift for my mom who loves cooking, budget $75');
formData.append('budget', '75');
formData.append('occasion', 'birthday');
formData.append('relationship', 'mother');

// Test API endpoint
fetch('/search-gifts', {
    method: 'POST',
    body: formData,
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
})
.then(response => {
    console.log('Response status:', response.status);
    if (response.ok) {
        return response.text();
    }
    throw new Error('Network response was not ok');
})
.then(html => {
    console.log('Success! Received HTML response');
    console.log('HTML length:', html.length);
    // You would normally replace the page content here
})
.catch(error => {
    console.error('Error:', error);
});

console.log("Test submitted!");