package pruebaRetrofitJava;

import java.io.IOException;
import java.util.Scanner;

import com.google.gson.Gson;
import okio.*;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;





/***************************************
 * SE PUEDEN DESCARGAR JARS DE CONVERTIDORES DE AQUÍ:
 * http://search.maven.org/
 * 
 * Por ejemplo:
 * http://search.maven.org/#search%7Cga%7C1%7Cg%3A%22com.squareup.retrofit2%22
 * 
 * Si usamos gradle, simplemente añadiríamos la dependencia:
 * com.squareup.retrofit2:converter-gson/home/migue/Descargas/converter-gson-2.1.0.jar
 *
 */



public class Principal {
	
	private final static String SERVER_URL = "http://libros.api:8080";

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		Retrofit retrofit;
		LibroCallback libroCallback = new LibroCallback();
		LibroDeleteCallback libroDeleteCallback = new LibroDeleteCallback();
		LibroListCallback libroListCallback = new LibroListCallback();
		LibroPostCallback libroPostCallback = new LibroPostCallback();
		LibroPutCallback libroPutCallback = new LibroPutCallback();
		LibroMinMaxListCallback libroMinMaxListCallback = new LibroMinMaxListCallback();
		Scanner sc = new Scanner(System.in);
		int opcion, id, minpag, maxpag;
		String tit, numpag;
		
		retrofit = new Retrofit.Builder()
							   .baseUrl(SERVER_URL)
							   .addConverterFactory(GsonConverterFactory.create())
							   .build();
		
		LibroInterface libroInter = retrofit.create(LibroInterface.class);

		do{
			do
			{
				System.out.println("Selecciona una opcion: \n");
				System.out.println("0.	Salir");
				System.out.println("1.	Obtener listado de libros");
				System.out.println("2.	Obtener libro por id");
				System.out.println("3.	Borrar libro");
				System.out.println("4.	Añadir libro");
				System.out.println("5.	Actualizar libro");
				System.out.println("6.	Buscar libro por paginas:  \n");

				opcion = sc.nextInt();
				if(opcion < 0 || opcion > 6)
					System.out.println("¡Solo entre 1 o 4, o 0 para salir!");
			}while(opcion < 0 || opcion > 6);

			switch (opcion){

				case 1:

					System.out.println("Listado de libros: \n");
					libroInter.getListaLibros().enqueue(libroListCallback);
					break;

				case 2:

					System.out.println("Introduce el id del libro a mostrar: ");
					id = sc.nextInt();
					libroInter.getLibro(id).enqueue(libroCallback);
					break;

				case 3:
					System.out.println("Introduce el id del libro a borrar: ");
					id = sc.nextInt();
					libroInter.deleteLibro(id).enqueue(libroDeleteCallback);
					break;

				case 4:
					System.out.println("Introduce el los datos del nuevo libro: \n");
					System.out.println("Numero de Paginas: ");
					numpag = sc.next();
					sc.nextLine();
					System.out.println("Titulo: ");
					tit = sc.nextLine();
					libroInter.postLibro(new Libro(0, tit, numpag)).enqueue(libroPostCallback);
					break;

				case 5:
					System.out.println("Introduce los datos y la id del libro a actualizar: \n");
					System.out.println("ID: ");
					id = sc.nextInt();
					System.out.println("Numero de Paginas: ");
					numpag = sc.next();
					sc.nextLine();
					System.out.println("Titulo: ");
					tit = sc.nextLine();
					libroInter.putLibro(new Libro(id, tit, numpag)).enqueue(libroPutCallback);
					break;

				case 6:
					System.out.println("Introduce el maximo de paginas: ");
					System.out.println("Minimo: ");
					minpag = sc.nextInt();
					System.out.println("Maximo: ");
					maxpag = sc.nextInt();
					libroInter.getMinMaxPagLibro(minpag, maxpag).enqueue(libroMinMaxListCallback);
					break;
			}

		}while(opcion != 0);

	}


	


}
