// Fonction pour ouvrir un onglet
        function openTab(evt, tabName) {
            const tabContents = document.getElementsByClassName("tab-content");
            for (let content of tabContents) {
                content.classList.remove("active");
            }

            const tabs = document.getElementsByClassName("tab");
            for (let tab of tabs) {
                tab.classList.remove("active");
            }

            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
            
            // Sauvegarder l'onglet actif dans localStorage
            localStorage.setItem('activeTab', tabName);
        }

        // Fonction pour restaurer l'onglet actif au chargement de la page
        function restoreActiveTab() {
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                // Simuler un clic sur l'onglet
                const tabButton = document.querySelector(`button.tab[onclick="openTab(event, '${activeTab}')"]`);
                if (tabButton) {
                    // Créer un événement factice
                    const evt = { currentTarget: tabButton };
                    openTab(evt, activeTab);
                }
            }
        }

    // Fonction pour la déconnexion
    function logout() {
        window.location.href = "site.php"; // Redirection vers la page d'accueil
    }

        // Ajouter l'écouteur d'événement pour le chargement de la page
        window.addEventListener('load', restoreActiveTab);


