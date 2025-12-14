<x-layouts.app>


    <style>
        /* CSS Bawaan Teman Anda (Saya hapus bagian Sidebar agar tidak bentrok dengan punya Anda) */
        body { margin: 0; font-family: Figtree, sans-serif; background-color: #f3f4f6; }
        
        /* Layout Container */
        .layout { display: flex; min-height: 100vh; }

        /* Content Area */
        .content { flex: 1; padding: 40px; overflow-y: auto; }
        
        /* Topbar/Navbar Area */
        .topbar { display: flex; justify-content: flex-end; margin-bottom: 30px; }

        /* Table Styling */
        .table-container { background: white; border-radius: 10px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #f9fafb; }
        th { padding: 14px; font-size: 14px; color: #6b7280; text-align: left; border-bottom: 1px solid #e5e7eb; }
        td { padding: 14px; border-bottom: 1px solid #e5e7eb; font-size: 15px; }

        /* Status colors */
        .status-progress { color: #6366f1; }
        .status-blocked { color: #ef4444; }
        .status-complete { color: #10b981; }
        .status-hold { color: #f59e0b; }
    </style>



    <div class="layout">


        
        <div class="content">
            
            <div class="topbar">
                    <span>Welcome, </span>
            </div>

            <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px;">Recent Project</h2>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Project Title</th>
                            <th>Report date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Identifikasi Bakat Olahraga Pada</td>
                            <td>30/10/2025</td>
                            <td class="status-progress">In Progress</td>
                        </tr>
                        <tr>
                            <td>Pengembangan Ilmu Olahraga</td>
                            <td>30/10/2025</td>
                            <td class="status-blocked">Blocked</td>
                        </tr>
                        <tr>
                            <td>Pengaruh Wortel terhadap skill lari</td>
                            <td>30/10/2025</td>
                            <td class="status-complete">Complete</td>
                        </tr>
                        <tr>
                            <td>Pengaruh tidur terhadap olahraga</td>
                            <td>30/10/2025</td>
                            <td class="status-hold">On Hold</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
    </div>
</x-layouts.app>