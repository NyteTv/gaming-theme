// Funktion zum Laden der Social Media Links
async function loadSocialMediaLinks() {
    try {
        const response = await fetch('/api/social-media');
        const links = await response.json();
        
        const container = document.getElementById('socialLinksContainer');
        container.innerHTML = ''; // Leere den Container
        
        links.forEach(link => {
            const linkElement = document.createElement('a');
            linkElement.href = link.url;
            linkElement.className = 'social-link';
            linkElement.target = '_blank'; // Öffne Links in neuem Tab
            
            const icon = document.createElement('i');
            icon.className = link.icon;
            
            linkElement.appendChild(icon);
            container.appendChild(linkElement);
        });
    } catch (error) {
        console.error('Fehler beim Laden der Social Media Links:', error);
    }
}

// Lade die Links beim Seitenstart
document.addEventListener('DOMContentLoaded', loadSocialMediaLinks);
